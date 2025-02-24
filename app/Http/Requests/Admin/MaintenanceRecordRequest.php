<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRecordRequest extends FormRequest
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
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'nullable|exists:units,id',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'reported_by' => 'required|string|max:255',
            'request_date' => 'required|date',
            'scheduled_date' => 'nullable|date|after:request_date',
            'estimated_time' => 'required|date_format:H:i',
            'estimated_cost' => 'required|numeric|min:0',
            'contractor_name' => 'nullable|string|max:255',
            'contractor_contact' => 'nullable|string|max:255',
            'work_order_number' => 'required|string|max:255|unique:maintenance_records,work_order_number,' . $this->maintenance_record?->id,
            'priority' => 'required|string|in:Emergency,High,Medium,Low',
            'category' => 'required|string|max:255',
            'materials_used' => 'nullable|json',
            'warranty_info' => 'nullable|string',
            'images' => 'nullable|json',
            'notes' => 'nullable|string',
            'assigned_to' => 'required|string|max:255',
            'approval_status' => 'required|string|in:Pending,Approved,Rejected',
            'status' => 'required|string|in:Pending,In Progress,Completed,Cancelled',
            'recurring' => 'boolean',
            'recurrence_interval' => 'nullable|integer|min:1|required_if:recurring,true'
        ];
    }
}
