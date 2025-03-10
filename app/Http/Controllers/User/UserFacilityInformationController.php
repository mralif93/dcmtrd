<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Issuer;
use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Http\Request;

class UserFacilityInformationController extends Controller
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

        return view('user.facility-informations.index', [
            'facilities' => $facilities,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $issuers = Issuer::all();
        return view('user.facility-informations.create', compact('issuers'));
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
            'principle_type' => 'required|max:50',
            'islamic_concept' => 'nullable|max:100',
            'maturity_date' => 'nullable|date',
            'instrument' => 'nullable|max:50',
            'instrument_type' => 'nullable|max:50',
            'guaranteed' => 'nullable|boolean',
            'total_guaranteed' => 'nullable|numeric|min:0',
            'indicator' => 'nullable|max:50',
            'facility_rating' => 'nullable|max:50',
            'facility_amount' => 'nullable|numeric|min:0',
            'available_limit' => 'nullable|numeric|min:0',
            'outstanding_amount' => 'nullable|numeric|min:0',
            'trustee_security_agent' => 'nullable|max:100',
            'lead_arranger' => 'nullable|max:100',
            'facility_agent' => 'nullable|max:100',
            'availability_date' => 'nullable|date',
        ]);

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        try {
            $facilityInformation = FacilityInformation::create($validated);
            return redirect()->route('facility-informations-info.show', $facilityInformation)->with('success', 'Facility created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FacilityInformation $facility_informations_info)
    {
        $facilityInformation = $facility_informations_info;
        $facility = $facilityInformation->load([
            'issuer' => function($query) {
                $query->with('bonds');
            },
        ]);
        return view('user.facility-informations.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FacilityInformation $facility_informations_info)
    {
        $facility = $facility_informations_info;
        $issuers = Issuer::all();
        return view('user.facility-informations.edit', compact('facility', 'issuers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FacilityInformation $facility_informations_info)
    {
        $facilityInformation = $facility_informations_info;

        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|max:50|unique:facility_informations,facility_code,'.$facilityInformation->id,
            'facility_number' => 'required|max:50|unique:facility_informations,facility_number,'.$facilityInformation->id,
            'facility_name' => 'required|max:100',
            'principle_type' => 'required|max:50',
            'islamic_concept' => 'nullable|max:100',
            'maturity_date' => 'nullable|date',
            'instrument' => 'nullable|max:50',
            'instrument_type' => 'nullable|max:50',
            'guaranteed' => 'nullable|boolean',
            'total_guaranteed' => 'nullable|numeric|min:0',
            'indicator' => 'nullable|max:50',
            'facility_rating' => 'nullable|max:50',
            'facility_amount' => 'nullable|numeric|min:0',
            'available_limit' => 'nullable|numeric|min:0',
            'outstanding_amount' => 'nullable|numeric|min:0',
            'trustee_security_agent' => 'nullable|max:100',
            'lead_arranger' => 'nullable|max:100',
            'facility_agent' => 'nullable|max:100',
            'availability_date' => 'nullable|date',
        ]);

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        try {
            $facilityInformation->update($validated);
            return redirect()->route('facility-informations-info.show', $facilityInformation)->with('success', 'Facility updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacilityInformation $facility_informations_info)
    {
        $facilityInformation = $facility_informations_info;

        try {
            $facilityInformation->delete();
            return redirect()->route('facility-informations-info.index')->with('success', 'Facility deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error delete: ' . $e->getMessage());
        }
    }
}
