<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Portfolio;
use App\Models\Unit;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::with('portfolio')->latest()->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $portfolios = Portfolio::pluck('portfolio_name', 'id');
        
        return view('admin.properties.create', compact('portfolios'));
    }

    /**
     * Store a newly created property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|exists:portfolios,id',
            'category' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'land_size' => 'required|numeric|min:0',
            'gross_floor_area' => 'required|numeric|min:0',
            'usage' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'ownership' => 'required|string|max:255',
            'share_amount' => 'required|numeric|min:0',
            'market_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Property::create($request->all());
            
            return redirect()->route('properties.index')
                ->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating property: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $portfolios = Portfolio::pluck('portfolio_name', 'id');
        
        return view('admin.properties.edit', compact('property', 'portfolios'));
    }

    /**
     * Update the specified property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'category' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'land_size' => 'required|numeric|min:0',
            'gross_floor_area' => 'required|numeric|min:0',
            'usage' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'ownership' => 'required|string|max:255',
            'share_amount' => 'required|numeric|min:0',
            'market_value' => 'required|numeric|min:0',
            'master_lease_agreement' => 'nullable|file|mimes:pdf|max:10240',
            'valuation_report' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'nullable|string|in:active,pending,rejected,inactive,under_maintenance,for_sale',
        ]);

        try {
            $property->update($validated);
            
            return redirect()
                ->route('properties.index')
                ->with('success', 'Property updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating property: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified property from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        try {
            $property->delete();
            
            return redirect()->route('properties.index')
                ->with('success', 'Property deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting property: ' . $e->getMessage());
        }
    }
    
    /**
     * Display a listing of the tenants for a specific property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function tenants(Property $property)
    {
        $tenants = $property->tenants;
        
        return view('admin.properties.tenants', compact('property', 'tenants'));
    }
    
    /**
     * Display a listing of the checklists for a specific property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function checklists(Property $property)
    {
        $checklists = $property->siteVisits->checklists;
        
        return view('admin.properties.checklists', compact('property', 'checklists'));
    }
    
    /**
     * Display a listing of the site visits for a specific property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function siteVisits(Property $property)
    {
        $siteVisits = $property->siteVisits;
        
        return view('admin.properties.site-visits', compact('property', 'siteVisits'));
    }
}
