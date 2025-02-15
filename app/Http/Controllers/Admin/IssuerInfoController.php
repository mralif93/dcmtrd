<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IssuerInfo;

class IssuerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issuersInfo = IssuerInfo::all(); // Fetch all issuer info records
        return view('issuers_info.index', compact('issuersInfo')); // Return a view with the data
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('issuers_info.create'); // Return the view for creating a new issuer info
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'security_name' => 'required|string|max:255',
            'isin_code' => 'required|string|max:50',
            'stock_code' => 'required|string|max:50',
            'instrument_code' => 'required|string|max:50',
            'category' => 'required|string|max:100',
            'issue_date' => 'required|date',
            'maturity_date' => 'required|date',
            'coupon_rate' => 'required|numeric',
            'coupon_type' => 'required|string|max:50',
            'coupon_frequency' => 'required|string|max:50',
            'day_count' => 'required|string|max:50',
            'issue_tenure_years' => 'required|numeric',
            'residual_tenure_years' => 'required|numeric',
            'sub_category' => 'required|string|max:100',
            'amount_issued' => 'nullable|numeric',
            'amount_outstanding' => 'nullable|numeric',
            'lead_arranger' => 'nullable|string|max:100',
            'facility_agent' => 'nullable|string|max:100',
            'facility_code' => 'nullable|string|max:50',
        ]);

        IssuerInfo::create($request->all()); // Create a new issuer info record

        return redirect()->route('issuers_info.index')->with('success', 'Issuer Info created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IssuerInfo $issuerInfo)
    {
        return view('admin.issuers_info.show', compact('issuerInfo')); // Return the view for showing a specific issuer info
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IssuerInfo $issuerInfo)
    {
        return view('admin.issuers_info.edit', compact('issuerInfo')); // Return the view for editing a specific issuer info
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IssuerInfo $issuerInfo)
    {
        $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'security_name' => 'required|string|max:255',
            'isin_code' => 'required|string|max:50',
            'stock_code' => 'required|string|max:50',
            'instrument_code' => 'required|string|max:50',
            'category' => 'required|string|max:100',
            'issue_date' => 'required|date',
            'maturity_date' => 'required|date',
            'coupon_rate' => 'required|numeric',
            'coupon_type' => 'required|string|max:50',
            'coupon_frequency' => 'required|string|max:50',
            'day_count' => 'required|string|max:50',
            'issue_tenure_years' => 'required|numeric',
            'residual_tenure_years' => 'required|numeric',
            'sub_category' => 'required|string|max:100',
            'amount_issued' => 'nullable|numeric',
            'amount_outstanding' => 'nullable|numeric',
            'lead_arranger' => 'nullable|string|max:100',
            'facility_agent' => 'nullable|string|max:100',
            'facility_code' => 'nullable|string|max:50',
        ]);

        $issuerInfo->update($request->all()); // Update the issuer info record

        return redirect()->route('issuers_info.index')->with('success', 'Issuer Info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IssuerInfo $issuerInfo)
    {
        $issuerInfo->delete(); // Delete the issuer info record

        return redirect()->route('issuers_info.index')-> with('success', 'Issuer Info deleted successfully.'); // Redirect with success message
    }
}
