<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FinancialReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|exists:portfolios,id',
            'report_type' => 'required|in:Monthly,Quarterly,Annual',
            'fiscal_period' => 'required|string|max:50',
            'report_date' => 'required|date',
            
            // Revenue
            'rental_revenue' => 'required|numeric|min:0',
            'other_revenue' => 'required|numeric|min:0',
            
            // Expenses
            'operating_expenses' => 'required|numeric|min:0',
            'maintenance_expenses' => 'required|numeric|min:0',
            'administrative_expenses' => 'required|numeric|min:0',
            'utility_expenses' => 'required|numeric|min:0',
            'insurance_expenses' => 'required|numeric|min:0',
            'property_tax' => 'required|numeric|min:0',
            
            // Other financial data
            'debt_service' => 'required|numeric|min:0',
            'capex' => 'required|numeric|min:0',
            'cash_flow' => 'required|numeric',
            
            // Performance metrics
            'occupancy_rate' => 'required|numeric|between:0,100',
            'debt_ratio' => 'required|numeric|min:0',
            
            // These fields are calculated in the controller
            'total_revenue' => 'sometimes|numeric',
            'net_operating_income' => 'sometimes|numeric',
            'net_income' => 'sometimes|numeric',
            'roi' => 'sometimes|numeric',
            'cap_rate' => 'sometimes|numeric',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'portfolio_id' => 'portfolio',
            'report_type' => 'report type',
            'fiscal_period' => 'fiscal period',
            'report_date' => 'report date',
            'rental_revenue' => 'rental revenue',
            'other_revenue' => 'other revenue',
            'operating_expenses' => 'operating expenses',
            'maintenance_expenses' => 'maintenance expenses',
            'administrative_expenses' => 'administrative expenses',
            'utility_expenses' => 'utility expenses',
            'insurance_expenses' => 'insurance expenses',
            'property_tax' => 'property tax',
            'debt_service' => 'debt service',
            'capex' => 'capital expenditures',
            'cash_flow' => 'cash flow',
            'occupancy_rate' => 'occupancy rate',
            'debt_ratio' => 'debt ratio',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be a number.',
            'min' => 'The :attribute must be at least :min.',
            'between' => 'The :attribute must be between :min and :max.',
            'exists' => 'The selected :attribute is invalid.',
            'in' => 'The selected :attribute is invalid.',
        ];
    }
}