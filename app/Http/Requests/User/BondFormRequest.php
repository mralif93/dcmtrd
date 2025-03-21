<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BondFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Required fields based on schema
            'issuer_id' => 'required|exists:issuers,id', 
            'bond_sukuk_name' => 'required|string|max:255',
            
            // Nullable fields based on schema
            'sub_name' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'principal' => 'nullable|string|max:255',
            'islamic_concept' => 'nullable|string|max:255',
            'isin_code' => 'nullable|string|max:255',
            'stock_code' => 'nullable|string|max:255',
            'instrument_code' => 'nullable|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'maturity_date' => 'nullable|date|after_or_equal:issue_date',
            
            // Nullable numeric fields with precision limits
            'coupon_rate' => 'nullable|numeric|min:0|max:99.9999',
            'issue_tenure_years' => 'nullable|numeric|min:0|max:99999999.9999',
            'residual_tenure_years' => 'nullable|numeric|min:0|max:99999999.9999',
            'last_traded_yield' => 'nullable|numeric|min:0|max:999.99',
            'last_traded_price' => 'nullable|numeric|min:0',
            'last_traded_amount' => 'nullable|numeric|min:0',
            'amount_issued' => 'nullable|numeric|min:0',
            'amount_outstanding' => 'nullable|numeric|min:0',
            
            // Nullable string fields with validation
            'coupon_type' => 'nullable|string|in:Fixed,Floating',
            'coupon_frequency' => 'nullable|string|in:Monthly,Quarterly,Semi-Annually,Annually',
            'day_count' => 'nullable|string|in:30/360,Actual/360,Actual/365',
            
            // Nullable date fields
            'last_traded_date' => 'nullable|date',
            'coupon_accrual' => 'nullable|date',
            'prev_coupon_payment_date' => 'nullable|date',
            'first_coupon_payment_date' => 'nullable|date',
            'next_coupon_payment_date' => 'nullable|date',
            'last_coupon_payment_date' => 'nullable|date',
            
            // Additional info fields
            'lead_arranger' => 'nullable|string|max:255',
            'facility_agent' => 'nullable|string|max:255',
            'facility_code' => 'nullable|string|max:255',
            
            // System info 
            'status' => 'nullable|string|in:Draft,Active,Inactive,Pending,Matured',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'issuer_id' => 'Issuer',
            'bond_sukuk_name' => 'Bond/Sukuk Name',
            'sub_name' => 'Sub Name',
            'issue_tenure_years' => 'Issue Tenure (Years)',
            'residual_tenure_years' => 'Residual Tenure (Years)',
            'coupon_accrual' => 'Coupon Accrual',
            'prev_coupon_payment_date' => 'Previous Coupon Payment Date',
            'first_coupon_payment_date' => 'First Coupon Payment Date',
            'next_coupon_payment_date' => 'Next Coupon Payment Date',
            'last_coupon_payment_date' => 'Last Coupon Payment Date',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'maturity_date.after_or_equal' => 'The maturity date must be on or after the issue date.',
            'coupon_rate.max' => 'The coupon rate cannot exceed 99.9999%.',
            'status.in' => 'The status must be one of: Active, Inactive, Pending, Matured.',
        ];
    }
}