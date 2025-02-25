<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRecordRequest;
use App\Models\MaintenanceRecord;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceRecordController extends Controller
{
    /**
     * Display a listing of the maintenance records.
     */
    public function index(Request $request)
    {
        $query = MaintenanceRecord::with(['property', 'unit'])
            ->orderBy('request_date', 'desc');
        
        // Apply filters
        if ($request->has('property_id') && $request->property_id) {
            $query->where('property_id', $request->property_id);
        }
        
        if ($request->has('unit_id') && $request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $query->where('request_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->where('request_date', '<=', $request->end_date);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('reported_by', 'like', "%{$search}%")
                  ->orWhere('work_order_number', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }
        
        // Statistics for dashboard
        $totalRecords = MaintenanceRecord::count();
        $pendingRecords = MaintenanceRecord::where('status', 'Pending')->count();
        $inProgressRecords = MaintenanceRecord::where('status', 'In Progress')->count();
        $completedRecords = MaintenanceRecord::where('status', 'Completed')->count();
        $highPriorityRecords = MaintenanceRecord::where('priority', 'High')->where('status', '!=', 'Completed')->count();
        
        $maintenanceRecords = $query->paginate(10);
        
        return view('admin.maintenance-records.index', compact(
            'maintenanceRecords',
            'totalRecords',
            'pendingRecords',
            'inProgressRecords',
            'completedRecords',
            'highPriorityRecords'
        ));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
    public function create(Request $request)
    {
        $properties = Property::all();
        $units = collect();
        
        // If property_id is provided, load its units
        if ($request->has('property_id') && $request->property_id) {
            $units = Unit::where('property_id', $request->property_id)->get();
        }
        
        // Default selected property and unit
        $selectedProperty = $request->property_id ?? null;
        $selectedUnit = $request->unit_id ?? null;
        
        return view('admin.maintenance-records.create', compact(
            'properties',
            'units',
            'selectedProperty',
            'selectedUnit'
        ));
    }

    /**
     * Store a newly created maintenance record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'nullable|exists:units,id',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'reported_by' => 'required|string|max:255',
            'request_date' => 'required|date',
            'scheduled_date' => 'nullable|date',
            'estimated_time' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'contractor_name' => 'nullable|string|max:255',
            'contractor_contact' => 'nullable|string|max:255',
            'work_order_number' => 'required|string|max:255|unique:maintenance_records',
            'priority' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'materials_used' => 'nullable|array',
            'warranty_info' => 'nullable|string',
            'images' => 'nullable|array',
            'notes' => 'nullable|string',
            'assigned_to' => 'required|string|max:255',
            'approval_status' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'recurring' => 'boolean',
            'recurrence_interval' => 'nullable|integer|min:1',
        ]);
        
        // Handle image uploads if present
        if ($request->hasFile('image_files')) {
            $imagePaths = [];
            foreach ($request->file('image_files') as $image) {
                $path = $image->store('maintenance-images', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }
        
        $maintenanceRecord = MaintenanceRecord::create($validated);
        
        return redirect()
            ->route('admin.maintenance-records.show', $maintenanceRecord)
            ->with('success', 'Maintenance record created successfully.');
    }

    /**
     * Display the specified maintenance record.
     */
    public function show(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->load(['property', 'unit']);
        
        return view('admin.maintenance-records.show', compact('maintenanceRecord'));
    }

    /**
     * Show the form for editing the specified maintenance record.
     */
    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $properties = Property::all();
        $units = Unit::where('property_id', $maintenanceRecord->property_id)->get();
        
        return view('admin.maintenance-records.edit', compact(
            'maintenanceRecord',
            'properties',
            'units'
        ));
    }

    /**
     * Update the specified maintenance record in storage.
     */
    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'nullable|exists:units,id',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'reported_by' => 'required|string|max:255',
            'request_date' => 'required|date',
            'scheduled_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'estimated_time' => 'required|string',
            'actual_time' => 'nullable|string',
            'estimated_cost' => 'required|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'contractor_name' => 'nullable|string|max:255',
            'contractor_contact' => 'nullable|string|max:255',
            'work_order_number' => 'required|string|max:255|unique:maintenance_records,work_order_number,'.$maintenanceRecord->id,
            'priority' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'materials_used' => 'nullable|array',
            'warranty_info' => 'nullable|string',
            'images' => 'nullable|array',
            'notes' => 'nullable|string',
            'assigned_to' => 'required|string|max:255',
            'approval_status' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'recurring' => 'boolean',
            'recurrence_interval' => 'nullable|integer|min:1',
        ]);
        
        // Handle new image uploads
        if ($request->hasFile('image_files')) {
            $currentImages = $maintenanceRecord->images ?? [];
            $newImages = [];
            
            foreach ($request->file('image_files') as $image) {
                $path = $image->store('maintenance-images', 'public');
                $newImages[] = $path;
            }
            
            $validated['images'] = array_merge($currentImages, $newImages);
        }
        
        $maintenanceRecord->update($validated);
        
        return redirect()
            ->route('maintenance.show', $maintenanceRecord)
            ->with('success', 'Maintenance record updated successfully.');
    }

    /**
     * Remove the specified maintenance record from storage.
     */
    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->delete();
        
        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Maintenance record deleted successfully.');
    }
    
    /**
     * Get units for a specific property (for AJAX requests).
     */
    public function getUnits(Request $request)
    {
        $propertyId = $request->property_id;
        $units = Unit::where('property_id', $propertyId)
            ->select('id', 'unit_number')
            ->get();
            
        return response()->json($units);
    }
    
    /**
     * Update the status of a maintenance record.
     */
    public function updateStatus(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'actual_cost' => 'nullable|numeric|min:0',
            'actual_time' => 'nullable|string',
        ]);
        
        // When changing to completed status, set the completion date if not provided
        if ($validated['status'] === 'Completed' && empty($validated['completion_date'])) {
            $validated['completion_date'] = now();
        }
        
        // Update notes by appending new note with timestamp
        if (!empty($validated['notes'])) {
            $existingNotes = $maintenanceRecord->notes ?? '';
            $timestamp = now()->format('Y-m-d H:i');
            $username = Auth::user()->name ?? 'System';
            $newNote = "[{$timestamp} - {$username}] {$validated['notes']}";
            
            if (!empty($existingNotes)) {
                $validated['notes'] = $existingNotes . "\n\n" . $newNote;
            } else {
                $validated['notes'] = $newNote;
            }
        }
        
        $maintenanceRecord->update($validated);
        
        return redirect()
            ->back()
            ->with('success', 'Maintenance record status updated successfully.');
    }
    
    /**
     * Display a dashboard/analytics view for maintenance records.
     */
    public function dashboard()
    {
        // Stats by property
        $propertyStats = Property::withCount(['maintenanceRecords' => function($query) {
                $query->where('created_at', '>=', now()->subMonths(6));
            }])
            ->with(['maintenanceRecords' => function($query) {
                $query->where('created_at', '>=', now()->subMonths(6))
                    ->selectRaw('property_id, SUM(actual_cost) as total_cost')
                    ->groupBy('property_id');
            }])
            ->get();
            
        // Stats by category
        $categoryStats = MaintenanceRecord::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('category, COUNT(*) as count, SUM(actual_cost) as total_cost')
            ->groupBy('category')
            ->get();
            
        // Stats by month
        $monthlyStats = MaintenanceRecord::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(request_date) as month, YEAR(request_date) as year, COUNT(*) as count, SUM(actual_cost) as total_cost')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Upcoming scheduled maintenance
        $upcomingMaintenance = MaintenanceRecord::where('scheduled_date', '>=', now())
            ->where('scheduled_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'Completed')
            ->with(['property', 'unit'])
            ->orderBy('scheduled_date')
            ->limit(10)
            ->get();
            
        return view('admin.maintenance-records.dashboard', compact(
            'propertyStats',
            'categoryStats',
            'monthlyStats',
            'upcomingMaintenance'
        ));
    }
}