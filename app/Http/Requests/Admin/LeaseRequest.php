<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LeaseRequest extends FormRequest
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
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:tenants,id',
            'lease_type' => 'required|string|in:Fixed,Month-to-Month',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'pet_deposit' => 'nullable|numeric|min:0',
            'utilities_included' => 'boolean',
            'payment_frequency' => 'required|string|in:Monthly,Quarterly,Annually',
            'late_fee_percentage' => 'required|numeric|between:0,100',
            'grace_period_days' => 'required|integer|min:0',
            'renewable' => 'boolean',
            'lease_term' => 'required|string|max:255',
            'payment_method' => 'required|string|in:ACH,Check,Credit Card',
            'parking_fee' => 'nullable|numeric|min:0',
            'storage_fee' => 'nullable|numeric|min:0',
            'special_conditions' => 'nullable|string',
            'guarantor_info' => 'nullable|json',
            'move_in_inspection' => 'required|date',
            'status' => 'required|string|in:Draft,Active,Terminated,Expired'
        ];
    }
}
