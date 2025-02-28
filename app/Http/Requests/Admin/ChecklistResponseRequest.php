<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChecklistResponseRequest extends FormRequest
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
            'checklist_id' => 'required|exists:checklists,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'completed_by' => 'required|string|max:255',
            'status' => 'required|string|in:Draft,Completed,Reviewed',
            'completed_at' => 'nullable|date',
            'reviewer' => 'nullable|string|max:255',
            'reviewed_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'response_data' => 'required|json',
            'images' => 'nullable|json',
            'attachments' => 'nullable|json'
        ];
    }
}
