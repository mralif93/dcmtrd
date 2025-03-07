<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PropertyImprovement;
use App\Models\Checklist;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPropertyImprovementController extends Controller
{
    /**
     * Display a listing of the property improvements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $improvements = PropertyImprovement::with(['checklist', 'checklist.property'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.property-improvements.index', compact('improvements'));
    }

    /**
     * Show the form for creating a new property improvement.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $checklists = Checklist::with('property')
            ->where('type', 'improvement')
            ->where('status', '!=', 'completed')
            ->get();
            
        return view('user.property-improvements.create', compact('checklists'));
    }

    /**
     * Store a newly created property improvement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'improvement_type' => 'required|string|max:255',
            'sub_type' => 'nullable|string|max:255',
            'scope_of_work' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'status' => 'required|in:pending,completed,not_applicable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $propertyImprovement = PropertyImprovement::create($request->all());

        return redirect()->route('property-improvements-info.show', $propertyImprovement)
            ->with('success', 'Property improvement created successfully.');
    }

    /**
     * Display the specified property improvement.
     *
     * @param  \App\Models\PropertyImprovement  $propertyImprovement
     * @return \Illuminate\View\View
     */
    public function show(PropertyImprovement $property_improvements_info)
    {
        $propertyImprovement = $property_improvements_info;
        $propertyImprovement->load(['checklist', 'checklist.property']);
        
        return view('user.property-improvements.show', compact('propertyImprovement'));
    }

    /**
     * Show the form for editing the specified property improvement.
     *
     * @param  \App\Models\PropertyImprovement  $propertyImprovement
     * @return \Illuminate\View\View
     */
    public function edit(PropertyImprovement $property_improvements_info)
    {
        $propertyImprovement = $property_improvements_info;
        $checklists = Checklist::with('property')
            ->where('type', 'improvement')
            ->get();
            
        return view('user.property-improvements.edit', compact('propertyImprovement', 'checklists'));
    }

    /**
     * Update the specified property improvement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyImprovement  $propertyImprovement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PropertyImprovement $property_improvements_info)
    {
        $propertyImprovement = $property_improvements_info;
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'improvement_type' => 'required|string|max:255',
            'sub_type' => 'nullable|string|max:255',
            'scope_of_work' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'status' => 'required|in:pending,completed,not_applicable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $propertyImprovement->update($request->all());

        return redirect()->route('property-improvements-info.show', $propertyImprovement)
            ->with('success', 'Property improvement updated successfully.');
    }

    /**
     * Remove the specified property improvement from storage.
     *
     * @param  \App\Models\PropertyImprovement  $propertyImprovement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PropertyImprovement $property_improvements_info)
    {
        $propertyImprovement = $property_improvements_info;
        $propertyImprovement->delete();

        return redirect()->route('property-improvements-info.index')
            ->with('success', 'Property improvement deleted successfully.');
    }
    
    /**
     * Display property improvements related to a specific property.
     *
     * @param  int  $propertyId
     * @return \Illuminate\View\View
     */
    public function propertyImprovements($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        
        $improvements = PropertyImprovement::whereHas('checklist', function($query) use ($propertyId) {
            $query->where('property_id', $propertyId);
        })->with('checklist')->paginate(10);
        
        return view('property-improvements-info.property', compact('improvements', 'property'));
    }
}
