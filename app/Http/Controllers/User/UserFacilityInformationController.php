<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Issuer;
use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFacilityInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $issuer_id = $request->input('issuer_id');
        $facility_code = $request->input('facility_code');
        $instrument_type = $request->input('instrument_type');
        $maturity_status = $request->input('maturity_status');
        
        $facilities = FacilityInformation::with('issuer')
            ->when($issuer_id, function ($query) use ($issuer_id) {
                $query->where('issuer_id', $issuer_id);
            })
            ->when($facility_code, function ($query) use ($facility_code) {
                $query->where('facility_code', 'like', "%{$facility_code}%");
            })
            ->when($instrument_type, function ($query) use ($instrument_type) {
                $query->where('instrument_type', 'like', "%{$instrument_type}%");
            })
            ->when($maturity_status, function ($query) use ($maturity_status) {
                if ($maturity_status === 'matured') {
                    $query->where('maturity_date', '<', now());
                } elseif ($maturity_status === 'current') {
                    $query->where('maturity_date', '>=', now());
                }
            })
            ->latest()
            ->paginate(10);

        $issuers = Issuer::all();

        return view('user.facility-informations.index', [
            'facilities' => $facilities,
            'issuers' => $issuers,
            'searchTerm' => $request->input('search')
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

    /**
     * Display a listing of trashed facilities.
     */
    public function trashed()
    {
        $trashedFacilities = FacilityInformation::onlyTrashed()
            ->with('issuer')
            ->latest('deleted_at')
            ->paginate(10);

        return view('user.facility-informations.trashed', compact('trashedFacilities'));
    }

    /**
     * Restore the specified facility.
     */
    public function restore($id)
    {
        try {
            $facility = FacilityInformation::onlyTrashed()->findOrFail($id);
            $facility->restore();
            return redirect()->route('facility-informations-info.trashed')
                ->with('success', 'Facility restored successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error restoring facility: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete the specified facility.
     */
    public function forceDelete($id)
    {
        try {
            $facility = FacilityInformation::onlyTrashed()->findOrFail($id);
            $facility->forceDelete();
            return redirect()->route('facility-informations-info.trashed')
                ->with('success', 'Facility permanently deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Error permanently deleting facility: ' . $e->getMessage());
        }
    }

    /**
     * Display the facility reports.
     */
    public function report(Request $request)
    {
        $maturity_start_date = $request->input('maturity_start_date');
        $maturity_end_date = $request->input('maturity_end_date');
        $issuer_id = $request->input('issuer_id');
        $maturity_status = $request->input('maturity_status');
        
        $facilities = FacilityInformation::with('issuer')
            ->when($maturity_start_date, function ($query) use ($maturity_start_date) {
                $query->where('maturity_date', '>=', $maturity_start_date);
            })
            ->when($maturity_end_date, function ($query) use ($maturity_end_date) {
                $query->where('maturity_date', '<=', $maturity_end_date);
            })
            ->when($issuer_id, function ($query) use ($issuer_id) {
                $query->where('issuer_id', $issuer_id);
            })
            ->when($maturity_status, function ($query) use ($maturity_status) {
                if ($maturity_status === 'matured') {
                    $query->where('maturity_date', '<', now());
                } elseif ($maturity_status === 'current') {
                    $query->where('maturity_date', '>=', now());
                }
            })
            ->latest()
            ->get();

        $total_facilities = $facilities->count();
        $total_amount = $facilities->sum('facility_amount');
        $total_outstanding = $facilities->sum('outstanding_amount');

        $issuers = Issuer::all();

        return view('user.facility-informations.report', compact(
            'facilities',
            'issuers',
            'total_facilities',
            'total_amount',
            'total_outstanding'
        ));
    }
}