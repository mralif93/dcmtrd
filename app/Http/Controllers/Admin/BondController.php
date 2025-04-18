<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BondController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $category = $request->input('category');
        $rating = $request->input('rating');
        $facilityCode = $request->input('facility_code');
        $status = $request->input('status');
        $showTrashed = $request->boolean('trashed');
        
        $bonds = Bond::with('issuer')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('bond_sukuk_name', 'like', "%$searchTerm%")
                      ->orWhere('isin_code', 'like', "%$searchTerm%")
                      ->orWhere('stock_code', 'like', "%$searchTerm%")
                      ->orWhereHas('issuer', function ($q) use ($searchTerm) {
                          $q->where('issuer_name', 'like', "%$searchTerm%");
                      });
                });
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($rating, function ($query) use ($rating) {
                $query->where('rating', $rating);
            })
            ->when($facilityCode, function ($query) use ($facilityCode) {
                $query->where('facility_code', 'like', "%$facilityCode%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($showTrashed, function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    
        return view('admin.bonds.index', compact('bonds', 'searchTerm', 'category', 'rating', 'facilityCode', 'status', 'showTrashed'));
    }

    public function create()
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('admin.bonds.create', compact('issuers'));
    }

    public function store(Request $request)
    {
        // validate request data
        $validated = $this->validateBond($request);

        try {
            $bond = Bond::create($validated);
            return redirect()->route('bonds.show', $bond)->with('success', 'Bond created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating bond: ' . $e->getMessage());
        }
    }

    public function show(Bond $bond)
    {
        $bond->load([
            'issuer',
            'ratingMovements',
            'paymentSchedules',
            'tradingActivities' => fn($q) => $q->latest()->limit(10),
            'redemption.callSchedules',
            'redemption.lockoutPeriods',
            'charts'
        ]);

        return view('admin.bonds.show', compact('bond'));
    }

    public function edit(Bond $bond)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('admin.bonds.edit', compact('bond', 'issuers'));
    }

    public function update(Request $request, Bond $bond)
    {
        $validated = $this->validateBond($request, $bond);

        try {
            $bond->update($validated);
            return redirect()->route('bonds.show', $bond)->with('success', 'Bond updated successfully');            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function destroy(Bond $bond)
    {
        try {
            $bond->delete();
            return redirect()->route('bonds.index')->with('success', 'Bond deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting bond: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the trashed bonds
     */
    public function trashed(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $bonds = Bond::onlyTrashed()
            ->with('issuer')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('bond_sukuk_name', 'like', "%$searchTerm%")
                      ->orWhere('isin_code', 'like', "%$searchTerm%")
                      ->orWhere('stock_code', 'like', "%$searchTerm%")
                      ->orWhereHas('issuer', function ($q) use ($searchTerm) {
                          $q->where('issuer_name', 'like', "%$searchTerm%");
                      });
                });
            })
            ->orderBy('deleted_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bonds.trashed', compact('bonds', 'searchTerm'));
    }

    /**
     * Restore the specified bond from soft delete
     */
    public function restore($id)
    {
        try {
            $bond = Bond::onlyTrashed()->findOrFail($id);
            $bond->restore();
            return redirect()->route('bonds.index')->with('success', 'Bond restored successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error restoring bond: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete the specified bond from storage
     */
    public function forceDelete($id)
    {
        try {
            $bond = Bond::withTrashed()->findOrFail($id);
            $bond->forceDelete();
            return redirect()->route('bonds.trashed')->with('success', 'Bond permanently deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Error permanently deleting bond: ' . $e->getMessage());
        }
    }

    protected function validateBond(Request $request, Bond $bond = null)
    {
        return $request->validate([
            'bond_sukuk_name' => 'required|string|max:255',
            'sub_name' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'principal' => 'nullable|string|max:100',
            'islamic_concept' => 'nullable|string|max:255',
            'isin_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'stock_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'instrument_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'sub_category' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'maturity_date' => 'nullable|date|after:issue_date',
            'coupon_rate' => 'nullable|numeric|between:0,100',
            'coupon_type' => 'nullable|in:Fixed,Floating',
            'coupon_frequency' => 'nullable|in:Monthly,Quarterly,Semi-Annually,Annually',
            'day_count' => 'nullable|string|max:50',
            'issue_tenure_years' => 'nullable|numeric|min:0',
            'residual_tenure_years' => 'nullable|numeric|min:0',
            'last_traded_yield' => 'nullable|numeric|min:0',
            'last_traded_price' => 'nullable|numeric|min:0',
            'last_traded_amount' => 'nullable|numeric|min:0',
            'last_traded_date' => 'nullable|date',
            'coupon_accrual' => 'nullable|date',
            'prev_coupon_payment_date' => 'nullable|date',
            'first_coupon_payment_date' => 'nullable|date',
            'next_coupon_payment_date' => 'nullable|date',
            'last_coupon_payment_date' => 'nullable|date',
            'amount_issued' => 'nullable|numeric|min:0',
            'amount_outstanding' => 'nullable|numeric|min:0',
            'lead_arranger' => 'nullable|string|max:255',
            'facility_agent' => 'nullable|string|max:255',
            'facility_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'status' => 'nullable|in:Active,Inactive,Matured,Pending',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
            'issuer_id' => 'required|exists:issuers,id',
        ], [
            'maturity_date.after' => 'Maturity date must be after issue date',
            'coupon_rate.between' => 'Coupon rate must be between 0 and 100 percent',
            'issuer_id.exists' => 'The selected issuer is invalid',
            'unique' => 'This :attribute is already in use',
        ]);
    }
}