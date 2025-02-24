<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteVisitRequest extends FormRequest
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
            'tenant_id' => 'nullable|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'property_id' => 'required|exists:properties,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'required|string|max:20',
            'visit_date' => 'required|date|after:today',
            'actual_visit_start' => 'nullable|date_format:Y-m-d H:i:s',
            'actual_visit_end' => 'nullable|date_format:Y-m-d H:i:s|after:actual_visit_start',
            'visit_type' => 'required|string|in:First Visit,Second Visit,Final Visit',
            'visit_status' => 'required|string|in:Scheduled,Completed,Cancelled,No-Show',
            'conducted_by' => 'required|string|max:255',
            'visitor_feedback' => 'nullable|string',
            'agent_notes' => 'nullable|string',
            'interested' => 'boolean',
            'quoted_price' => 'nullable|numeric|min:0',
            'requirements' => 'nullable|json',
            'source' => 'required|string|max:255',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date|after:visit_date|required_if:follow_up_required,true'
        ];
    }
}
