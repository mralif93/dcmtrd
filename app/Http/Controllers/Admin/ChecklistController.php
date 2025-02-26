<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChecklistRequest;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Models\ChecklistResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Checklist::withCount(['items', 'responses']);

        // Apply filters
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        if ($request->has('is_template') && $request->is_template !== '') {
            $query->where('is_template', $request->is_template);
        }

        $checklists = $query->latest()->paginate(10);
        
        // Get stats
        $templateCount = Checklist::where('is_template', true)->count();
        $itemCount = ChecklistItem::count();
        $responseCount = ChecklistResponse::count();

        return view('admin.checklists.index', compact('checklists', 'templateCount', 'itemCount', 'responseCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.checklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Move-in,Move-out,Inspection,Maintenance',
            'description' => 'nullable|string',
            'is_template' => 'sometimes|boolean',
            'active' => 'sometimes|boolean',
            'sections' => 'required|array|min:1',
            'sections.*' => 'required|string|max:255',
        ]);

        // Set default values for checkboxes if not present
        $validated['is_template'] = $request->has('is_template') ? true : false;
        $validated['active'] = $request->has('active') ? true : false;

        $checklist = Checklist::create($validated);

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'Checklist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {
        $responses = $checklist->responses()->with(['unit.property', 'tenant'])->latest()->paginate(5);
        
        return view('admin.checklists.show', compact('checklist', 'responses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        return view('admin.checklists.edit', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Move-in,Move-out,Inspection,Maintenance',
            'description' => 'nullable|string',
            'is_template' => 'sometimes|boolean',
            'active' => 'sometimes|boolean',
            'sections' => 'required|array|min:1',
            'sections.*' => 'required|string|max:255',
        ]);

        // Set default values for checkboxes if not present
        $validated['is_template'] = $request->has('is_template') ? true : false;
        $validated['active'] = $request->has('active') ? true : false;

        $checklist->update($validated);

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'Checklist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        // Check if the checklist has any responses
        if ($checklist->responses()->exists()) {
            return back()->with('error', 'Cannot delete a checklist that has responses.');
        }

        // Delete associated items
        $checklist->items()->delete();
        
        // Delete the checklist
        $checklist->delete();

        return redirect()->route('checklists.index')
            ->with('success', 'Checklist deleted successfully.');
    }

    /**
     * Show the form for creating a new response.
     */
    public function createResponse(Checklist $checklist)
    {
        // This is a stub method to match the route in your show.blade.php
        // The implementation would depend on your ChecklistResponse model and views
        return redirect()->route('checklists.show', $checklist);
    }
}
