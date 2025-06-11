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
        $issuers = Issuer::all();
        return view('admin.facility-informations.create', compact('issuers'));
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
            return redirect()->route('facility-informations.show', $facilityInformation)->with('success', 'Facility created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(FacilityInformation $facilityInformation)
    {
        return view('admin.facility-informations.show', [
            'facility' => $facilityInformation->load([
                'issuer' => function ($query) {
                    $query->with('bonds');
                },
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
            'facility_code' => 'required|max:50|unique:facility_informations,facility_code,' . $facilityInformation->id,
            'facility_number' => 'required|max:50|unique:facility_informations,facility_number,' . $facilityInformation->id,
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
            return redirect()->route('facility-informations.show', $facilityInformation)->with('success', 'Facility updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacilityInformation $facilityInformation)
    {
        try {
            $facilityInformation->delete();
            return redirect()->route('facility-informations.index')->with('success', 'Facility deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error delete: ' . $e->getMessage());
        }
    }

    public function trashed()
    {
        $trashedFacilities = FacilityInformation::onlyTrashed()->paginate(10);

        return view('admin.facility-informations.trashed', compact('trashedFacilities'));
    }

    public function restore($id)
    {
        $facility = FacilityInformation::onlyTrashed()->findOrFail($id);
        $facility->restore();

        return redirect()->route('admin.facility-informations.trashed')->with('success', 'Facility restored successfully.');
    }

    public function forceDelete($id)
    {
        $facility = FacilityInformation::onlyTrashed()->findOrFail($id);
        $facility->forceDelete();

        return redirect()->route('admin.facility-informations.trashed')->with('success', 'Facility permanently deleted.');
    }
}
