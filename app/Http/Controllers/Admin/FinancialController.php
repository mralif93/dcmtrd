<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Portfolio;
use App\Models\Bank;
use App\Models\FinancialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialController extends Controller
{
    /**
     * Display a listing of the financials.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financials = Financial::with(['portfolio', 'bank', 'financialType'])->latest()->paginate(10);
        
        return view('admin.financials.index', compact('financials'));
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
        
        return view('admin.financials.create', compact('portfolios', 'banks', 'financialTypes'));
    }

    /**
     * Store a newly created financial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateFinancial($request);
        
        $financial = Financial::create([
            'portfolio_id' => $request->portfolio_id,
            'bank_id' => $request->bank_id,
            'financial_type_id' => $request->financial_type_id,
            'purpose' => $request->purpose,
            'tenure' => $request->tenure,
            'installment_date' => $request->installment_date,
            'profit_type' => $request->profit_type,
            'profit_rate' => $request->profit_rate,
            'process_fee' => $request->process_fee,
            'total_facility_amount' => $request->total_facility_amount,
            'utilization_amount' => $request->utilization_amount,
            'outstanding_amount' => $request->outstanding_amount,
            'interest_monthly' => $request->interest_monthly,
            'security_value_monthly' => $request->security_value_monthly,
            'facilities_agent' => $request->facilities_agent,
            'agent_contact' => $request->agent_contact,
            'valuer' => $request->valuer,
            'status' => $request->status ?? 'active',
        ]);
        
        return redirect()->route('financials.index')
            ->with('success', 'Financial record created successfully.');
    }

    /**
     * Display the specified financial.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function show(Financial $financial)
    {
        $financial->load(['portfolio', 'bank', 'financialType']);
        
        return view('admin.financials.show', compact('financial'));
    }

    /**
     * Show the form for editing the specified financial.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function edit(Financial $financial)
    {
        $portfolios = Portfolio::where('status', 'active')->get();
        $banks = Bank::where('status', 'active')->get();
        $financialTypes = FinancialType::where('status', 'active')->get();
        
        return view('admin.financials.edit', compact('financial', 'portfolios', 'banks', 'financialTypes'));
    }

    /**
     * Update the specified financial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Financial $financial)
    {
        $this->validateFinancial($request);
        
        $financial->update([
            'portfolio_id' => $request->portfolio_id,
            'bank_id' => $request->bank_id,
            'financial_type_id' => $request->financial_type_id,
            'purpose' => $request->purpose,
            'tenure' => $request->tenure,
            'installment_date' => $request->installment_date,
            'profit_type' => $request->profit_type,
            'profit_rate' => $request->profit_rate,
            'process_fee' => $request->process_fee,
            'total_facility_amount' => $request->total_facility_amount,
            'utilization_amount' => $request->utilization_amount,
            'outstanding_amount' => $request->outstanding_amount,
            'interest_monthly' => $request->interest_monthly,
            'security_value_monthly' => $request->security_value_monthly,
            'facilities_agent' => $request->facilities_agent,
            'agent_contact' => $request->agent_contact,
            'valuer' => $request->valuer,
            'status' => $request->status ?? $financial->status,
        ]);
        
        return redirect()->route('financials.index')
            ->with('success', 'Financial record updated successfully.');
    }

    /**
     * Remove the specified financial from storage.
     *
     * @param  \App\Models\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Financial $financial)
    {
        $financial->delete();
        
        return redirect()->route('financials.index')
            ->with('success', 'Financial record deleted successfully.');
    }
    
    /**
     * Validate financial input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function validateFinancial(Request $request)
    {
        $rules = [
            'portfolio_id' => 'required|exists:portfolios,id',
            'bank_id' => 'required|exists:banks,id',
            'financial_type_id' => 'required|exists:financial_types,id',
            'purpose' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'installment_date' => 'required|date',
            'profit_type' => 'required|string|max:255',
            'profit_rate' => 'required|numeric|min:0',
            'process_fee' => 'required|numeric|min:0',
            'total_facility_amount' => 'required|numeric|min:0',
            'utilization_amount' => 'required|numeric|min:0',
            'outstanding_amount' => 'required|numeric|min:0',
            'interest_monthly' => 'required|numeric|min:0',
            'security_value_monthly' => 'required|numeric|min:0',
            'facilities_agent' => 'required|string|max:255',
            'agent_contact' => 'nullable|string|max:255',
            'valuer' => 'required|string|max:255',
            'status' => 'nullable|string|in:active,inactive,pending,completed',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        $validator->validate();
    }
}
