<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BondController extends Controller
{
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

        return view('admin.bonds.index', compact('bonds', 'searchTerm'));
    }

    public function create()
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('admin.bonds.create', compact('issuers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBond($request);
        
        try {
            DB::beginTransaction();
            
            $bond = Bond::create($validated);
            $bond->updateOutstandingAmount();
            
            DB::commit();

            return redirect()->route('bonds.show', $bond)
                ->with('success', 'Bond created successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating bond: ' . $e->getMessage());
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
            DB::beginTransaction();
            
            $bond->update($validated);
            $bond->updateOutstandingAmount();
            $bond->markAsMatured();
            
            DB::commit();

            return redirect()->route('bonds.show', $bond)
                ->with('success', 'Bond updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating bond: ' . $e->getMessage());
        }
    }

    public function destroy(Bond $bond)
    {
        try {
            DB::beginTransaction();
            
            $bond->delete();
            
            DB::commit();

            return redirect()->route('bonds.index')
                ->with('success', 'Bond deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting bond: ' . $e->getMessage());
        }
    }

    protected function validateBond(Request $request, Bond $bond = null)
    {
        return $request->validate([
            'bond_sukuk_name' => 'required|string|max:255',
            'sub_name' => 'nullable|string|max:255',
            'issuer_id' => 'required|exists:issuers,id',
            'isin_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'stock_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'instrument_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'sub_category' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'maturity_date' => 'required|date|after:issue_date',
            'coupon_rate' => 'required|numeric|between:0,100',
            'coupon_type' => 'required|in:Fixed,Floating',
            'coupon_frequency' => 'required|in:Monthly,Quarterly,Semi-Annual,Annual',
            'day_count' => 'required|string|max:50',
            'principal' => 'required|numeric|min:0',
            'o_s_amount' => 'required|numeric|min:0',
            'rating' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Matured,Called',
            'amount_issued' => 'required|numeric|min:0',
            'amount_outstanding' => 'required|numeric|min:0',
            'lead_arranger' => 'nullable|string|max:255',
            'facility_agent' => 'nullable|string|max:255',
            'facility_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'last_traded_yield' => 'nullable|numeric|min:0',
            'last_traded_price' => 'nullable|numeric|min:0',
            'last_traded_amount' => 'nullable|numeric|min:0',
            'last_traded_date' => 'nullable|date',
            'prev_coupon_payment_date' => 'nullable|date',
            'first_coupon_payment_date' => 'nullable|date',
            'next_coupon_payment_date' => 'nullable|date',
            'last_coupon_payment_date' => 'nullable|date',
            'coupon_accrual' => 'nullable|numeric|min:0',
            'approval_date_time' => 'nullable|date',
            'ratings' => 'nullable|json',
            'issue_tenure_years' => 'required|integer|min:1',
            'residual_tenure_years' => 'required|integer|min:0',
        ], [
            'maturity_date.after' => 'Maturity date must be after issue date',
            'coupon_rate.between' => 'Coupon rate must be between 0 and 100 percent',
            'issuer_id.exists' => 'The selected issuer is invalid',
            'unique' => 'This :attribute is already in use',
        ]);
    }
}