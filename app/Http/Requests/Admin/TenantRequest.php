<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tenants,email,' . $this->tenant?->id,
            'phone' => 'required|string|max:20',
            'ssn' => 'required|string|max:11|unique:tenants,ssn,' . $this->tenant?->id,
            'date_of_birth' => 'required|date|before:-18 years',
            'current_address' => 'required|string|max:255',
            'employment_status' => 'required|string|in:Employed,Self-Employed,Retired,Unemployed',
            'employer_name' => 'nullable|string|max:255',
            'annual_income' => 'required|numeric|min:0',
            'emergency_contact' => 'required|string|max:255',
            'credit_score' => 'required|string|max:255',
            'background_check_date' => 'required|date',
            'background_check_status' => 'required|string|in:Passed,Failed,Pending',
            'identity_proof_type' => 'required|string|max:255',
            'pets' => 'boolean',
            'number_of_occupants' => 'required|integer|min:1',
            'vehicle_info' => 'nullable|json',
            'insurance_policy' => 'nullable|string|max:255',
            'preferred_contact_method' => 'required|string|in:Email,Phone,SMS',
            'bank_details' => 'required|json',
            'active_status' => 'boolean'
        ];
    }
}
