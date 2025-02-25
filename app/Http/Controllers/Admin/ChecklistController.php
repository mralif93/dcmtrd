<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChecklistRequest;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Models\ChecklistResponse;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the checklists.
     */
    public function index(Request $request)
    {
        $query = Checklist::query();
        
        // Apply search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }
        
        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Apply template filter
        if ($request->filled('is_template')) {
            $query->where('is_template', $request->is_template == 'true');
        }
        
        // Apply active filter
        if ($request->filled('active')) {
            $query->where('active', $request->active == 'true');
        }
        
        // Get checklists with counts
        $checklists = $query->withCount(['items', 'responses'])
                            ->latest()
                            ->paginate(10)
                            ->withQueryString();
        
        // Get checklist types for filter dropdown
        $types = Checklist::select('type')
                         ->distinct()
                         ->pluck('type')
                         ->filter()
                         ->toArray();
        
        return view('admin.checklists.index', compact('checklists', 'types'));
    }

    /**
     * Show the form for creating a new checklist.
     */
    public function create()
    {
        // Get available templates
        $templates = Checklist::where('is_template', true)
                             ->where('active', true)
                             ->pluck('name', 'id');
        
        return view('admin.checklists.create', compact('templates'));
    }

    /**
     * Store a newly created checklist in storage.
     */
    public function store(ChecklistRequest $request)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create checklist
            $checklist = Checklist::create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'is_template' => $request->has('is_template'),
                'active' => $request->has('active'),
                'sections' => $request->sections
            ]);
            
            // If copying from template
            if ($request->filled('template_id')) {
                $template = Checklist::findOrFail($request->template_id);
                
                // Copy items from template
                foreach ($template->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->checklist_id = $checklist->id;
                    $newItem->save();
                }
            }
            
            // Save items if provided
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $itemData) {
                    ChecklistItem::create([
                        'checklist_id' => $checklist->id,
                        'question' => $itemData['question'],
                        'type' => $itemData['type'],
                        'section' => $itemData['section'] ?? null,
                        'options' => $itemData['options'] ?? null,
                        'required' => isset($itemData['required']) && $itemData['required'],
                        'order' => $itemData['order'] ?? 0
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()
                ->route('checklists.show', $checklist)
                ->with('success', 'Checklist created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create checklist: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified checklist.
     */
    public function show(Checklist $checklist)
    {
        // Load checklist items
        $checklist->load(['items' => function($query) {
            $query->orderBy('section')->orderBy('order');
        }]);
        
        // Group items by section
        $itemsBySection = [];
        foreach ($checklist->sections ?? [] as $section) {
            $itemsBySection[$section['id']] = $checklist->items->where('section', $section['id'])->values();
        }
        
        // Get items without a section
        $unsectionedItems = $checklist->items->whereNull('section')->values();
        
        // Get recent responses
        $recentResponses = ChecklistResponse::where('checklist_id', $checklist->id)
                                         ->with(['tenant', 'unit.property'])
                                         ->latest()
                                         ->take(5)
                                         ->get();
        
        // Get response statistics
        $completedCount = ChecklistResponse::where('checklist_id', $checklist->id)
                                        ->whereNotNull('completed_at')
                                        ->count();
                                        
        $reviewedCount = ChecklistResponse::where('checklist_id', $checklist->id)
                                       ->whereNotNull('reviewed_at')
                                       ->count();
                                       
        $totalCount = ChecklistResponse::where('checklist_id', $checklist->id)->count();
        
        $stats = [
            'completed' => $completedCount,
            'reviewed' => $reviewedCount,
            'total' => $totalCount,
            'completion_rate' => $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0,
            'review_rate' => $totalCount > 0 ? round(($reviewedCount / $totalCount) * 100) : 0
        ];
        
        return view('admin.checklists.show', compact(
            'checklist', 
            'itemsBySection', 
            'unsectionedItems', 
            'recentResponses', 
            'stats'
        ));
    }

    /**
     * Show the form for editing the specified checklist.
     */
    public function edit(Checklist $checklist)
    {
        // Load checklist items
        $checklist->load(['items' => function($query) {
            $query->orderBy('section')->orderBy('order');
        }]);
        
        return view('admin.checklists.edit', compact('checklist'));
    }

    /**
     * Update the specified checklist in storage.
     */
    public function update(ChecklistRequest $request, Checklist $checklist)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Update checklist
            $checklist->update([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'is_template' => $request->has('is_template'),
                'active' => $request->has('active'),
                'sections' => $request->sections
            ]);
            
            // Handle item updates if provided
            if ($request->has('items') && is_array($request->items)) {
                // Get current item IDs
                $existingItemIds = $checklist->items->pluck('id')->toArray();
                $updatedItemIds = [];
                
                foreach ($request->items as $itemData) {
                    if (isset($itemData['id'])) {
                        // Update existing item
                        $item = ChecklistItem::find($itemData['id']);
                        if ($item && $item->checklist_id == $checklist->id) {
                            $item->update([
                                'question' => $itemData['question'],
                                'type' => $itemData['type'],
                                'section' => $itemData['section'] ?? null,
                                'options' => $itemData['options'] ?? null,
                                'required' => isset($itemData['required']) && $itemData['required'],
                                'order' => $itemData['order'] ?? 0
                            ]);
                            $updatedItemIds[] = $item->id;
                        }
                    } else {
                        // Create new item
                        $item = ChecklistItem::create([
                            'checklist_id' => $checklist->id,
                            'question' => $itemData['question'],
                            'type' => $itemData['type'],
                            'section' => $itemData['section'] ?? null,
                            'options' => $itemData['options'] ?? null,
                            'required' => isset($itemData['required']) && $itemData['required'],
                            'order' => $itemData['order'] ?? 0
                        ]);
                        $updatedItemIds[] = $item->id;
                    }
                }
                
                // Delete items that weren't updated or created
                $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
                if (!empty($itemsToDelete)) {
                    ChecklistItem::whereIn('id', $itemsToDelete)->delete();
                }
            }
            
            DB::commit();
            
            return redirect()
                ->route('checklists.show', $checklist)
                ->with('success', 'Checklist updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to update checklist: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified checklist from storage.
     */
    public function destroy(Checklist $checklist)
    {
        // Check if there are any responses
        if ($checklist->responses()->exists()) {
            return back()->with('error', 'Cannot delete checklist with existing responses. Archive it instead.');
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Delete all items
            $checklist->items()->delete();
            
            // Delete the checklist
            $checklist->delete();
            
            DB::commit();
            
            return redirect()
                ->route('checklists.index')
                ->with('success', 'Checklist deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Failed to delete checklist: ' . $e->getMessage());
        }
    }
    
    /**
     * Create a new response for this checklist.
     */
    public function createResponse(Request $request, Checklist $checklist)
    {
        // Get properties and units for selection
        $properties = Property::orderBy('name')->pluck('name', 'id');
        
        // Get units if property selected
        $units = collect();
        if ($request->filled('property_id')) {
            $units = Unit::where('property_id', $request->property_id)
                       ->orderBy('unit_number')
                       ->get()
                       ->pluck('unit_number', 'id');
        }
        
        // Get tenants if unit selected
        $tenants = collect();
        if ($request->filled('unit_id')) {
            $unit = Unit::find($request->unit_id);
            if ($unit && $unit->currentTenant) {
                $tenants = collect([$unit->currentTenant->id => $unit->currentTenant->first_name . ' ' . $unit->currentTenant->last_name]);
            } else {
                // Get all active tenants if no tenant is assigned to the unit
                $tenants = Tenant::where('active_status', true)
                              ->get()
                              ->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id');
            }
        }
        
        // Load checklist items
        $checklist->load(['items' => function($query) {
            $query->orderBy('section')->orderBy('order');
        }]);
        
        return view('admin.checklists.create-response', compact(
            'checklist', 
            'properties', 
            'units', 
            'tenants'
        ));
    }
    
    /**
     * Store a new response for this checklist.
     */
    public function storeResponse(Request $request, Checklist $checklist)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:tenants,id',
            'response_data' => 'required|array',
            'images.*' => 'sometimes|image|max:5120', // 5MB max size
            'attachments.*' => 'sometimes|file|max:10240', // 10MB max size
            'completed' => 'sometimes|boolean'
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Handle file uploads
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('checklist-images', 'public');
                    $images[$key] = [
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType()
                    ];
                }
            }
            
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $key => $file) {
                    $path = $file->store('checklist-attachments', 'public');
                    $attachments[$key] = [
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType()
                    ];
                }
            }
            
            // Create response
            $checklistResponse = ChecklistResponse::create([
                'checklist_id' => $checklist->id,
                'tenant_id' => $request->tenant_id,
                'unit_id' => $request->unit_id,
                'response_data' => $request->response_data,
                'images' => $images,
                'attachments' => $attachments,
                'completed_at' => $request->has('completed') ? now() : null
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('checklist-responses.show', $checklistResponse)
                ->with('success', 'Checklist response submitted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to submit checklist response: ' . $e->getMessage());
        }
    }
    
    /**
     * Clone a checklist (especially useful for templates).
     */
    public function clone(Checklist $checklist)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Clone the checklist
            $newChecklist = $checklist->replicate();
            $newChecklist->name = 'Copy of ' . $checklist->name;
            $newChecklist->save();
            
            // Clone checklist items
            foreach ($checklist->items as $item) {
                $newItem = $item->replicate();
                $newItem->checklist_id = $newChecklist->id;
                $newItem->save();
            }
            
            DB::commit();
            
            return redirect()
                ->route('checklists.edit', $newChecklist)
                ->with('success', 'Checklist cloned successfully. You can now customize it.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Failed to clone checklist: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the active status of a checklist.
     */
    public function toggleActive(Checklist $checklist)
    {
        $checklist->active = !$checklist->active;
        $checklist->save();
        
        $status = $checklist->active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Checklist {$status} successfully");
    }
    
    /**
     * Export all responses for a checklist.
     */
    public function exportResponses(Checklist $checklist)
    {
        $responses = ChecklistResponse::where('checklist_id', $checklist->id)
                                   ->with(['tenant', 'unit.property'])
                                   ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="checklist_responses_' . $checklist->id . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($checklist, $responses) {
            $handle = fopen('php://output', 'w');
            
            // Add header row
            $headerRow = ['Response ID', 'Date', 'Tenant', 'Property', 'Unit', 'Completed', 'Reviewed'];
            
            // Add question headers
            foreach ($checklist->items as $item) {
                $headerRow[] = $item->question;
            }
            
            fputcsv($handle, $headerRow);
            
            // Add response rows
            foreach ($responses as $response) {
                $row = [
                    $response->id,
                    $response->created_at->format('Y-m-d H:i'),
                    $response->tenant ? $response->tenant->first_name . ' ' . $response->tenant->last_name : 'N/A',
                    $response->unit && $response->unit->property ? $response->unit->property->name : 'N/A',
                    $response->unit ? $response->unit->unit_number : 'N/A',
                    $response->completed_at ? 'Yes' : 'No',
                    $response->reviewed_at ? 'Yes' : 'No'
                ];
                
                // Add question responses
                foreach ($checklist->items as $item) {
                    $itemResponse = isset($response->response_data[$item->id]) ? $response->response_data[$item->id] : 'N/A';
                    
                    // Format the response based on item type
                    if (is_array($itemResponse)) {
                        $itemResponse = implode(', ', $itemResponse);
                    } elseif ($item->type === 'boolean') {
                        $itemResponse = $itemResponse ? 'Yes' : 'No';
                    }
                    
                    $row[] = $itemResponse;
                }
                
                fputcsv($handle, $row);
            }
            
            fclose($handle);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get units for a property (AJAX).
     */
    public function getUnits(Request $request)
    {
        if (!$request->filled('property_id')) {
            return response()->json(['units' => []]);
        }
        
        $units = Unit::where('property_id', $request->property_id)
                   ->orderBy('unit_number')
                   ->get()
                   ->map(function($unit) {
                       return [
                           'id' => $unit->id,
                           'name' => $unit->unit_number,
                           'available' => $unit->status === 'Available'
                       ];
                   });
                   
        return response()->json(['units' => $units]);
    }
    
    /**
     * Get tenants for a unit (AJAX).
     */
    public function getTenants(Request $request)
    {
        if (!$request->filled('unit_id')) {
            return response()->json(['tenants' => []]);
        }
        
        $unit = Unit::find($request->unit_id);
        $tenants = [];
        
        if ($unit && $unit->currentTenant) {
            $tenants[] = [
                'id' => $unit->currentTenant->id,
                'name' => $unit->currentTenant->first_name . ' ' . $unit->currentTenant->last_name,
                'current' => true
            ];
        } else {
            // Get all active tenants if no tenant is assigned to the unit
            $tenants = Tenant::where('active_status', true)
                        ->get()
                        ->map(function($tenant) {
                            return [
                                'id' => $tenant->id,
                                'name' => $tenant->first_name . ' ' . $tenant->last_name,
                                'current' => false
                            ];
                        });
        }
                   
        return response()->json(['tenants' => $tenants]);
    }
}