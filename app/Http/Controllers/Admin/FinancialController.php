<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Bond;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $financials = Financial::latest()->paginate(5);
        return view('admin.financials.index', compact('financials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all bonds to populate the related bond dropdown
        $bonds = Bond::all(); // Make sure to import the Bond model at the top of your controller
    
        return view('admin.financials.create', compact('bonds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'financial_year' => 'required|string|max:255',
            'revenue' => 'required|numeric',
            'net_income' => 'required|numeric',
            'total_assets' => 'required|numeric',
            'total_liabilities' => 'required|numeric',
            'issuer_id' => 'required|exists:issuers,issuer_id',
        ]);

        Financial::create($request->all());
        return redirect()->route('financials.index')->with('success', 'Financial record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Financial $financial)
    {
        return view('financials.show', compact('financial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Financial $financial)
    {
        return view('financials.edit', compact('financial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Financial $financial)
    {
        $request->validate([
            'financial_year' => 'required|string|max:255',
            'revenue' => 'required|numeric',
            'net_income' => 'required|numeric',
            'total_assets' => 'required|numeric',
            'total_liabilities' => 'required|numeric',
        ]);

        $financial->update($request->all());
        return redirect()->route('financials.index')->with('success', 'Financial record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Financial $financial)
    {
        $financial->delete();
        return redirect()->route('financials.index')->with('success', 'Financial record deleted successfully.');
    }
}
