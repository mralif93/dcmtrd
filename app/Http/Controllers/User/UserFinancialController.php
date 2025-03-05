<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Portfolio;
use App\Models\Bank;
use App\Models\FinancialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFinancialController extends Controller
{
    /**
     * Display a listing of the financials.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financials = Financial::with(['portfolio', 'bank', 'financialType'])->get();
        return view('user.financials.index', compact('financials'));
    }

    /**
     * Show the form for creating a new financial.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $portfolios = Portfolio::where('status', 'active')->get();
        $banks = Bank::where('status', 'active')->get();
        $financialTypes = FinancialType::where('status', 'active')->get();
        
        return view('user.financials.create', compact('portfolios', 'banks', 'financialTypes'));
    }

    /**
     * Store a newly created financial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|exists:portfolios,id',
            'bank_id' => 'required|exists:banks,id',
            'financial_type_id' => 'required|exists:financial_types,id',
            'purpose' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'installment_date' => 'required|date',
            'profit_type' => 'required|string|max:255',
            'profit_rate' => 'required|numeric|min:0|max:100',
            'process_fee' => 'required|numeric|min:0',
            'total_facility_amount' => 'required|numeric|min:0',
            'utilization_amount' => 'required|numeric|min:0',
            'outstanding_amount' => 'required|numeric|min:0',
            'interest_monthly' => 'required|numeric|min:0',
            'security_value_monthly' => 'required|numeric|min:0',
            'facilities_agent' => 'required|string|max:255',
            'agent_contact' => 'nullable|string|max:255',
            'valuer' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,pending',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $financial = Financial::create($request->all());

        return redirect()->route('financials-info.show', $financial)
            ->with('success', 'Financial record created successfully.');
    }

    /**
     * Display the specified financial.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function show(Financial $financials_info)
    {
        $financial = $financials_info;
        $financial->load(['portfolio', 'bank', 'financialType']);
        return view('user.financials.show', compact('financial'));
    }

    /**
     * Show the form for editing the specified financial.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function edit(Financial $financials_info)
    {
        $financial = $financials_info;
        $portfolios = Portfolio::where('status', 'active')->get();
        $banks = Bank::where('status', 'active')->get();
        $financialTypes = FinancialType::where('status', 'active')->get();
        
        return view('user.financials.edit', compact('financial', 'portfolios', 'banks', 'financialTypes'));
    }

    /**
     * Update the specified financial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Financial $financials_info)
    {
        $financial = $financials_info;
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|exists:portfolios,id',
            'bank_id' => 'required|exists:banks,id',
            'financial_type_id' => 'required|exists:financial_types,id',
            'purpose' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'installment_date' => 'required|date',
            'profit_type' => 'required|string|max:255',
            'profit_rate' => 'required|numeric|min:0|max:100',
            'process_fee' => 'required|numeric|min:0',
            'total_facility_amount' => 'required|numeric|min:0',
            'utilization_amount' => 'required|numeric|min:0',
            'outstanding_amount' => 'required|numeric|min:0',
            'interest_monthly' => 'required|numeric|min:0',
            'security_value_monthly' => 'required|numeric|min:0',
            'facilities_agent' => 'required|string|max:255',
            'agent_contact' => 'nullable|string|max:255',
            'valuer' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,pending',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $financial->update($request->all());

        return redirect()->route('financials-info.show', $financial)
            ->with('success', 'Financial record updated successfully.');
    }

    /**
     * Remove the specified financial from storage.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Financial $financials_info)
    {
        $financial = $financials_info;
        $financial->delete();

        return redirect()->route('financials-info.index')
            ->with('success', 'Financial record deleted successfully.');
    }
}