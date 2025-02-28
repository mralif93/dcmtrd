<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteVisit;
use App\Models\Unit;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteVisits = SiteVisit::with(['property', 'unit', 'tenant'])->latest()->paginate(10);
        return view('admin.site-visits.index', compact('siteVisits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::all();
        $units = Unit::all();
        $tenants = Tenant::all();
        
        $visitTypes = ['First Visit', 'Second Visit', 'Final Visit'];
        $visitStatuses = ['Scheduled', 'Completed', 'Cancelled', 'No-Show'];
        $sources = ['Website', 'Referral', 'Agent', 'Social Media', 'Other'];
        
        return view('admin.site-visits.create', compact(
            'properties', 
            'units', 
            'tenants', 
            'visitTypes', 
            'visitStatuses', 
            'sources'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'visit_type' => 'required|string|max:255',
            'visit_status' => 'required|string|max:255',
            'conducted_by' => 'required|string|max:255',
            'visitor_feedback' => 'nullable|string',
            'agent_notes' => 'nullable|string',
            'interested' => 'boolean',
            'quoted_price' => 'nullable|numeric',
            'requirements' => 'nullable|json',
            'source' => 'required|string|max:255',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date|after_or_equal:visit_date',
        ]);
        
        SiteVisit::create($validated);
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteVisit $siteVisit)
    {
        return view('admin.site-visits.show', compact('siteVisit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteVisit $siteVisit)
    {
        $properties = Property::all();
        $units = Unit::all();
        $tenants = Tenant::all();
        
        $visitTypes = ['First Visit', 'Second Visit', 'Final Visit'];
        $visitStatuses = ['Scheduled', 'Completed', 'Cancelled', 'No-Show'];
        $sources = ['Website', 'Referral', 'Agent', 'Social Media', 'Other'];
        
        return view('admin.site-visits.edit', compact(
            'siteVisit',
            'properties', 
            'units', 
            'tenants', 
            'visitTypes', 
            'visitStatuses', 
            'sources'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteVisit $siteVisit)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'actual_visit_start' => 'nullable|date',
            'actual_visit_end' => 'nullable|date|after_or_equal:actual_visit_start',
            'visit_type' => 'required|string|max:255',
            'visit_status' => 'required|string|max:255',
            'conducted_by' => 'required|string|max:255',
            'visitor_feedback' => 'nullable|string',
            'agent_notes' => 'nullable|string',
            'interested' => 'boolean',
            'quoted_price' => 'nullable|numeric',
            'requirements' => 'nullable|json',
            'source' => 'required|string|max:255',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date|after_or_equal:visit_date',
        ]);
        
        $siteVisit->update($validated);
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteVisit $siteVisit)
    {
        $siteVisit->delete();
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit deleted successfully.');
    }
}