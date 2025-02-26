<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Http\Requests\Admin\ChecklistItemRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChecklistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ChecklistItem::query()->with('checklist');
        
        // Apply filters
        if ($request->has('checklist_id') && $request->checklist_id) {
            $query->where('checklist_id', $request->checklist_id);
        }
        
        if ($request->has('section') && $request->section) {
            $query->where('section', $request->section);
        }
        
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        $items = $query->orderBy('section')->orderBy('order')->paginate(15);
        
        // Get unique sections for filter dropdown
        $sections = ChecklistItem::distinct('section')->pluck('section')->filter()->toArray();
        
        // Get checklists for filter dropdown
        $checklists = Checklist::pluck('name', 'id');
        
        return view('admin.checklist-items.index', compact('items', 'sections', 'checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get checklist from request
        $checklist = Checklist::findOrFail($request->checklist_id);
        
        return view('admin.checklist-items.create', compact('checklist'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get checklist from request
        $checklist = Checklist::findOrFail($request->checklist_id);
        
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'section' => [
                'required',
                'string',
                Rule::in($checklist->sections),
            ],
            'description' => 'nullable|string',
            'type' => 'required|string|in:Boolean,Text,Number,Rating',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'required' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        // Filter out empty options
        if (isset($validated['options'])) {
            $validated['options'] = array_values(array_filter($validated['options'], function ($value) {
                return !is_null($value) && $value !== '';
            }));
            
            // If no options left and type is Rating, default to empty array
            if (empty($validated['options']) && $validated['type'] === 'Rating') {
                $validated['options'] = [];
            }
        } elseif ($validated['type'] === 'Rating') {
            // If type is Rating but no options, set empty array
            $validated['options'] = [];
        }

        // Set required value correctly
        $validated['required'] = isset($validated['required']) ? true : false;
        
        $item = $checklist->items()->create($validated);
        
        return redirect()->route('checklists.edit', $checklist->id)
            ->with('success', 'Checklist item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistItem $checklistItem)
    {
        $item = $checklistItem;
        $checklist = $item->checklist;
        
        return view('admin.checklist-items.show', compact('item', 'checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistItem $checklistItem)
    {
        $item = $checklistItem;
        $checklist = $item->checklist;
        
        return view('admin.checklist-items.edit', compact('item', 'checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChecklistItem $checklistItem)
    {
        $item = $checklistItem;
        $checklist = Checklist::findOrFail($request->checklist_id);
        
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'section' => [
                'required',
                'string',
                Rule::in($checklist->sections),
            ],
            'description' => 'nullable|string',
            'type' => 'required|string|in:Boolean,Text,Number,Rating',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'required' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        // Filter out empty options
        if (isset($validated['options'])) {
            $validated['options'] = array_values(array_filter($validated['options'], function ($value) {
                return !is_null($value) && $value !== '';
            }));
            
            // If no options left and type is Rating, default to empty array
            if (empty($validated['options']) && $validated['type'] === 'Rating') {
                $validated['options'] = [];
            }
        } elseif ($validated['type'] === 'Rating') {
            // If type is Rating but no options, set empty array
            $validated['options'] = [];
        }

        // Set required value correctly
        $validated['required'] = isset($validated['required']) ? true : false;
        
        $item->update($validated);
        
        return redirect()->route('checklists.edit', $checklist->id)
            ->with('success', 'Checklist item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistItem $checklistItem)
    {
        $item = $checklistItem;
        $checklist_id = $item->checklist_id;
        
        $item->delete();
        
        return redirect()->route('checklists.edit', $checklist_id)
            ->with('success', 'Checklist item deleted successfully.');
    }
}