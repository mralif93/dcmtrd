<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserChecklistController extends Controller
{
    /**
     * Display a listing of the checklists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checklists = Checklist::with('property')->get();
        return view('user.checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new checklist.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        return view('user.checklists.create', compact('properties'));
    }

    /**
     * Store a newly created checklist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'approval_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $checklist = Checklist::create($request->all());

        return redirect()->route('checklists-info.show', $checklist)
            ->with('success', 'Checklist created successfully.');
    }

    /**
     * Display the specified checklist.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $checklist->load('property');
        return view('user.checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified checklist.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $properties = Property::where('status', 'active')->get();
        return view('user.checklists.edit', compact('checklist', 'properties'));
    }

    /**
     * Update the specified checklist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'approval_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $checklist->update($request->all());

        return redirect()->route('checklists-info.show', $checklist)
            ->with('success', 'Checklist updated successfully.');
    }

    /**
     * Remove the specified checklist from storage.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $checklist->delete();

        return redirect()->route('checklists-info.index')
            ->with('success', 'Checklist deleted successfully.');
    }
}