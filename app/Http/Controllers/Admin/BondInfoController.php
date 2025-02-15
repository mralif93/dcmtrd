<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\BondInfo;
use App\Models\Bond;
use Carbon\Carbon;

class BondInfoController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $bondInfos = BondInfo::with('bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('isin_code', 'like', "%{$searchTerm}%")
                      ->orWhere('stock_code', 'like', "%{$searchTerm}%")
                      ->orWhere('category', 'like', "%{$searchTerm}%")
                      ->orWhere('sub_category', 'like', "%{$searchTerm}%")
                      ->orWhere('instrument_code', 'like', "%{$searchTerm}%")
                      ->orWhereHas('bond', function($q) use ($searchTerm) {
                          $q->where('name', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->paginate($request->input('per_page', 10))
            ->withQueryString();
    
        return view('admin.bonds-info.index', compact('bondInfos', 'searchTerm'));
    }

    public function create()
    {
        $bonds = Bond::all();
        return view('admin.bonds-info.create', compact('bonds'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        
        try {
            BondInfo::create($this->filterRequestData($validated));
            return redirect()->route('bonds-info.index')->with('success', 'Bond Information created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating bond information: ' . $e->getMessage());
        }
    }

    public function show(BondInfo $bondInfo)
    {
        // Load relationships normally
        $bondInfo->load([
            'bond.issuer', 
            'ratingMovements',
            'paymentSchedules',
            'tradingActivities',
            'redemption'
        ]);
        return view('admin.bonds-info.show', compact('bondInfo'));
    }

    public function edit(BondInfo $bondInfo)
    {
        $bonds = Bond::all();
        return view('admin.bonds-info.edit', compact('bondInfo', 'bonds'));
    }

    public function update(Request $request, BondInfo $bondInfo)
    {
        $validated = $this->validateRequest($request, $bondInfo);
        
        try {
            $bondInfo->update($this->filterRequestData($validated));
            return redirect()->route('bonds-info.index')->with('success', 'Bond Information updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating bond information: ' . $e->getMessage());
        }
    }

    public function destroy(BondInfo $bondInfo)
    {
        try {
            $bondInfo->delete();
            return redirect()->route('bonds-info.index')->with('success', 'Bond Information deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting bond information: ' . $e->getMessage());
        }
    }

    private function validateRequest(Request $request, $bondInfo = null)
    {
        $rules = [
            // Foreign Key
            'bond_id' => 'required|exists:bonds,id',
            
            // General Information
            'principal' => 'required|numeric|min:0|max:9999999999999999.99',
            'islamic_concept' => 'required|string|max:100',
            'stock_code' => 'required|string|max:10',
            'instrument_code' => 'required|string|max:20',
            'category' => 'required|string|max:50',
            'sub_category' => 'required|string|max:50',
            'issue_date' => 'required|date|before:maturity_date',
            'maturity_date' => 'required|date|after:issue_date',
        
            // Coupon Information
            'coupon_rate' => 'required|numeric|between:0,99.99',
            'coupon_type' => 'required|in:Fixed,Floating',
            'coupon_frequency' => 'required|in:Monthly,Quarterly,Semi-Annual,Annual',
            'day_count' => 'required|in:30/360,Actual/360,Actual/365',
        
            // Tenure Information
            'issue_tenure_years' => 'required|integer|min:0|max:65535',
            'residual_tenure_years' => 'required|integer|min:0|max:65535|lte:issue_tenure_years',
        
            // Trading Information
            'last_traded_yield' => 'required|numeric|min:0|max:999999.99',
            'last_traded_price' => 'required|numeric|min:0|max:99999999.9999',
            'last_traded_amount' => 'required|numeric|min:0|max:9999999999999999.99',
            'last_traded_date' => 'required|date|before_or_equal:today',
        
            // Coupon Payments
            'coupon_accrual' => 'required|numeric|min:0|max:9999999999999999.99',
            'prev_coupon_payment_date' => 'required|date',
            'first_coupon_payment_date' => 'required|date',
            'next_coupon_payment_date' => 'required|date',
            'last_coupon_payment_date' => 'required|date',
        
            // Issuance Details
            'amount_issued' => 'required|numeric|min:0|max:9999999999999999.99',
            'amount_outstanding' => 'required|numeric|min:0|max:9999999999999999.99',
        
            // Additional Info
            'lead_arranger' => 'required|string|max:100',
            'facility_agent' => 'required|string|max:100',
            'facility_code' => 'required|string|max:50',
        ];

        // Unique ISIN handling
        $rules['isin_code'] = $bondInfo
            ? 'required|size:12|unique:bond_infos,isin_code,' . $bondInfo->id
            : 'required|size:12|unique:bond_infos';

        return $request->validate($rules);
    }

    private function filterRequestData(array $validated)
    {
        return array_merge($validated, [
            'last_traded_date' => $validated['last_traded_date'] ?? Carbon::today(),
            // Add other date transformations if needed
        ]);
    }
}