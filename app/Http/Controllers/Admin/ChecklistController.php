<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the checklists.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $checklists = Checklist::with('property')->paginate(10);
        
        return view('admin.checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new checklist.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.checklists.create', compact('properties'));
    }

    /**
     * Store a newly created checklist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'approval_date' => 'required|date',
            'status' => 'required|string|in:pending,approved,rejected'
        ]);

        Checklist::create($request->all());
        
        return redirect()->route('checklists.index')
            ->with('success', 'Checklist created successfully');
    }

    /**
     * Display the specified checklist.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\View\View
     */
    public function show(Checklist $checklist)
    {
        $checklist->load('property');
        
        return view('admin.checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified checklist.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\View\View
     */
    public function edit(Checklist $checklist)
    {
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.checklists.edit', compact('checklist', 'properties'));
    }

    /**
     * Update the specified checklist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Checklist $checklist)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'approval_date' => 'required|date',
            'status' => 'required|string|in:pending,approved,rejected'
        ]);

        $checklist->update($request->all());
        
        return redirect()->route('checklists.index')
            ->with('success', 'Checklist updated successfully');
    }

    /**
     * Remove the specified checklist from storage.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        
        return redirect()->route('checklists.index')
            ->with('success', 'Checklist deleted successfully');
    }
}
