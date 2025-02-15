<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuer;
use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Http\Request;

class FacilityInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $facilities = FacilityInformation::with('issuer')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('facility_code', 'like', "%{$searchTerm}%")
                      ->orWhere('facility_name', 'like', "%{$searchTerm}%")
                      ->orWhereHas('issuer', function ($q) use ($searchTerm) {
                          $q->where('issuer_name', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.facility-informations.index', [
            'facilities' => $facilities,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.facility-informations.create', [
            'issuers' => Issuer::all(),
            'instrumentTypes' => ['Sukuk', 'Conventional', 'Hybrid']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|unique:facility_informations|max:50',
            'facility_number' => 'required|unique:facility_informations|max:50',
            'facility_name' => 'required|max:100',
            'principal_type' => 'required|max:50',
            'islamic_concept' => 'nullable|max:100',
            'maturity_date' => 'required|date',
            'instrument' => 'required|max:50',
            'instrument_type' => 'required|in:Sukuk,Conventional,Hybrid',
            'guaranteed' => 'boolean',
            'total_guaranteed' => 'required_if:guaranteed,true|numeric|min:0',
            'indicator' => 'required|max:50',
            'facility_rating' => 'required|max:10',
            'facility_amount' => 'required|numeric|min:0',
            'available_limit' => 'required|numeric|min:0',
            'outstanding_amount' => 'required|numeric|min:0',
            'trustee_security_agent' => 'required|max:100',
            'lead_arranger' => 'required|max:100',
            'facility_agent' => 'required|max:100',
            'availability_date' => 'required|date',
        ]);

        FacilityInformation::create($validated);

        return redirect()->route('facility-informations.index')
            ->with('success', 'Facility created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(FacilityInformation $facilityInformation)
    {
        return view('admin.facility-informations.show', [
            'facility' => $facilityInformation->load([
                'issuer' => function($query) {
                    $query->with('bonds');
                },
                'documents' => function($query) {
                    $query->latest();
                }
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FacilityInformation $facilityInformation)
    {
        return view('admin.facility-informations.edit', [
            'facility' => $facilityInformation,
            'issuers' => Issuer::all(),
            'instrumentTypes' => ['Sukuk', 'Conventional', 'Hybrid']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FacilityInformation $facilityInformation)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|max:50|unique:facility_informations,facility_code,'.$facilityInformation->id,
            'facility_number' => 'required|max:50|unique:facility_informations,facility_number,'.$facilityInformation->id,
            'facility_name' => 'required|max:100',
            'principal_type' => 'required|max:50',
            'islamic_concept' => 'nullable|max:100',
            'maturity_date' => 'required|date',
            'instrument' => 'required|max:50',
            'instrument_type' => 'required|in:Sukuk,Conventional,Hybrid',
            'guaranteed' => 'boolean',
            'total_guaranteed' => 'required_if:guaranteed,true|numeric|min:0',
            'indicator' => 'required|max:50',
            'facility_rating' => 'required|max:10',
            'facility_amount' => 'required|numeric|min:0',
            'available_limit' => 'required|numeric|min:0',
            'outstanding_amount' => 'required|numeric|min:0',
            'trustee_security_agent' => 'required|max:100',
            'lead_arranger' => 'required|max:100',
            'facility_agent' => 'required|max:100',
            'availability_date' => 'required|date',
        ]);

        $facilityInformation->update($validated);

        return redirect()->route('facility-informations.index')
            ->with('success', 'Facility updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacilityInformation $facilityInformation)
    {
        $facilityInformation->delete();

        return redirect()->route('facility-informations.index')
            ->with('success', 'Facility deleted successfully');
    }
}