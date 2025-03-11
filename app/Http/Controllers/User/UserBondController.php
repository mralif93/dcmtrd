<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserBondController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $searchTerm = $request->input('search');

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
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('user.bonds.index', compact('bonds', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('user.bonds.create', compact('issuers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request data
        $validated = $this->validateBond($request);

        try {
            $bond = Bond::create($validated);
            return redirect()->route('bonds-info.show', $bond)->with('success', 'Bond created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bond $bonds_info)
    {
        $bond = $bonds_info;
        $bond->load([
            'issuer',
            'ratingMovements',
            'paymentSchedules',
            'tradingActivities',
            'redemption.callSchedules',
            'redemption.lockoutPeriods',
            'charts'
        ]);

        return view('user.bonds.show', compact('bond'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bond $bonds_info)
    {
        $bond = $bonds_info;
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('user.bonds.edit', compact('bond', 'issuers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bond $bonds_info)
    {
        $bond = $bonds_info;
        $validated = $this->validateBond($request, $bond);

        try {
            $bond->update($validated);
            return redirect()->route('bonds-info.show', $bond)->with('success', 'Bond updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bond $bonds_info)
    {
        $bond = $bonds_info;

        try {
            $bond->delete();
            return redirect()->route('bonds.index')->with('success', 'Bond deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting bond: ' . $e->getMessage());
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
            'approval_date_time' => 'nullable|date',
            'issuer_id' => 'required|exists:issuers,id',
        ], [
            'maturity_date.after' => 'Maturity date must be after issue date',
            'coupon_rate.between' => 'Coupon rate must be between 0 and 100 percent',
            'issuer_id.exists' => 'The selected issuer is invalid',
            'unique' => 'This :attribute is already in use',
        ]);
    }
}
