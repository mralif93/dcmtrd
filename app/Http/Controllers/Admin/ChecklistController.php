<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\SiteVisit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the checklists.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Checklist::query();

        // Apply filters if provided
        if ($request->filled('property_location')) {
            $query->where('property_location', $request->property_location);
        }

        if ($request->filled('tenant_name')) {
            $query->where('tenant_name', $request->tenant_name);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get distinct property locations and tenant names for filter dropdowns
        $propertyLocations = Checklist::distinct()->pluck('property_location')->filter()->values();
        $tenantNames = Checklist::distinct()->pluck('tenant_name')->filter()->values();

        $checklists = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.checklists.index', compact('checklists', 'propertyLocations', 'tenantNames'));
    }

    /**
     * Show the form for creating a new checklist.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $siteVisits = SiteVisit::with('property')->where('status', 'completed')->get();
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.checklists.create', compact('siteVisits', 'properties'));
    }

    /**
     * Store a newly created checklist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateChecklist($request);
        
        Checklist::create($validated);
        
        return redirect()->route('admin.checklists.index')
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
        $checklist->load('siteVisit.property');
        
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
        $siteVisits = SiteVisit::with('property')->where('status', 'completed')->get();
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.checklists.edit', compact('checklist', 'siteVisits', 'properties'));
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
        $validated = $this->validateChecklist($request);
        
        $checklist->update($validated);
        
        return redirect()->route('admin.checklists.index')
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
        
        return redirect()->route('admin.checklists.index')
            ->with('success', 'Checklist deleted successfully');
    }

    /**
     * Validate the checklist data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function validateChecklist(Request $request)
    {
        return $request->validate([
            // General Information
            'site_visit_id' => 'nullable|exists:site_visits,id',
            'property_title' => 'nullable|string|max:255',
            'property_location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
            
            // Legal Documentation
            'title_ref' => 'nullable|string|max:255',
            'title_location' => 'nullable|string|max:255',
            'trust_deed_ref' => 'nullable|string|max:255',
            'trust_deed_location' => 'nullable|string|max:255',
            'sale_purchase_agreement' => 'nullable|string|max:255',
            'lease_agreement_ref' => 'nullable|string|max:255',
            'lease_agreement_location' => 'nullable|string|max:255',
            'agreement_to_lease' => 'nullable|string|max:255',
            'maintenance_agreement_ref' => 'nullable|string|max:255',
            'maintenance_agreement_location' => 'nullable|string|max:255',
            'development_agreement' => 'nullable|string|max:255',
            'other_legal_docs' => 'nullable|string',
            
            // Tenancy Information
            'tenant_name' => 'nullable|string|max:255',
            'tenant_property' => 'nullable|string|max:255',
            'tenancy_approval_date' => 'nullable|date',
            'tenancy_commencement_date' => 'nullable|date',
            'tenancy_expiry_date' => 'nullable|date',
            
            // External Conditions
            'is_general_cleanliness_satisfied' => 'nullable|boolean',
            'is_fencing_gate_satisfied' => 'nullable|boolean',
            'is_external_facade_satisfied' => 'nullable|boolean',
            'is_car_park_satisfied' => 'nullable|boolean',
            'is_land_settlement_satisfied' => 'nullable|boolean',
            'is_rooftop_satisfied' => 'nullable|boolean',
            'is_drainage_satisfied' => 'nullable|boolean',
            'external_remarks' => 'nullable|string',
            
            // Internal Conditions
            'is_door_window_satisfied' => 'nullable|boolean',
            'is_staircase_satisfied' => 'nullable|boolean',
            'is_toilet_satisfied' => 'nullable|boolean',
            'is_ceiling_satisfied' => 'nullable|boolean',
            'is_wall_satisfied' => 'nullable|boolean',
            'is_water_seeping_satisfied' => 'nullable|boolean',
            'is_loading_bay_satisfied' => 'nullable|boolean',
            'is_basement_car_park_satisfied' => 'nullable|boolean',
            'internal_remarks' => 'nullable|string',
            
            // Property Development
            'development_expansion_status' => 'nullable|string|max:255',
            'renovation_status' => 'nullable|string|max:255',
            'external_repainting_status' => 'nullable|string|max:255',
            'water_tank_status' => 'nullable|string|max:255',
            'air_conditioning_approval_date' => 'nullable|date',
            'air_conditioning_scope' => 'nullable|string',
            'air_conditioning_status' => 'nullable|string|max:255',
            'lift_escalator_status' => 'nullable|string|max:255',
            'fire_system_status' => 'nullable|string|max:255',
            'other_property' => 'nullable|string',
            'other_proposals_approvals' => 'nullable|string',
        ]);
    }
}