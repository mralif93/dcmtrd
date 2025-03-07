<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DocumentationItem;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserDocumentationItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DocumentationItem::with(['checklist']);
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('document_type', 'like', "%{$search}%")
                  ->orWhere('item_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
        }
        
        // Filter by checklist
        if ($request->has('checklist_id') && !empty($request->checklist_id)) {
            $query->where('checklist_id', $request->checklist_id);
        }
        
        // Filter by prefilled status
        if ($request->has('is_prefilled') && $request->is_prefilled != 'all') {
            $isPrefilled = $request->is_prefilled === 'yes';
            $query->where('is_prefilled', $isPrefilled);
        }
        
        $documentationItems = $query->orderBy('checklist_id')->orderBy('item_number')->paginate(10);
        
        // Get all checklists for the filter dropdown
        $checklists = Checklist::where('type', 'documentation')->orderBy('id')->get();
        
        return view('user.documentation-items.index', compact('documentationItems', 'checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only show documentation type checklists
        $checklists = Checklist::where('type', 'documentation')->orderBy('id')->get();
        
        return view('user.documentation-items.create', compact('checklists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'document_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'validity_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_prefilled' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documentation-items.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Adjust the is_prefilled value (checkboxes come in as "on" or null)
        $data = $request->all();
        $data['is_prefilled'] = isset($data['is_prefilled']) ? true : false;
        
        try {
            DB::beginTransaction();
            
            $documentationItem = DocumentationItem::create($data);
            
            DB::commit();
            
            return redirect()->route('documentation-items-info.show', $documentationItem)
                ->with('success', 'Documentation item created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create documentation item: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentationItem $documentation_items_info)
    {
        $documentationItem = $documentation_items_info;
        $documentationItem->load('checklist.property');
        
        return view('user.documentation-items.show', compact('documentationItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentationItem $documentation_items_info)
    {
        $documentationItem = $documentation_items_info;
        $checklists = Checklist::where('type', 'documentation')->orderBy('id')->get();
        
        return view('user.documentation-items.edit', compact('documentationItem', 'checklists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentationItem $documentation_items_info)
    {
        $documentationItem = $documentation_items_info;
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'document_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'validity_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_prefilled' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documentation-items.edit', $documentationItem->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Adjust the is_prefilled value (checkboxes come in as "on" or null)
        $data = $request->all();
        $data['is_prefilled'] = isset($data['is_prefilled']) ? true : false;
        
        try {
            DB::beginTransaction();
            
            $documentationItem->update($data);
            
            DB::commit();
            
            return redirect()->route('documentation-items-info.show', $documentationItem)
                ->with('success', 'Documentation item updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update documentation item: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentationItem $documentation_items_info)
    {
        $documentationItem = $documentation_items_info;
        
        try {
            DB::beginTransaction();
            
            $documentationItem->delete();
            
            DB::commit();
            
            return redirect()->route('documentation-items-info.index')
                ->with('success', 'Documentation item deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete documentation item: ' . $e->getMessage()]);
        }
    }
}