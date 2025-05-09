<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFundTransferRequest extends FormRequest
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
            'date' => 'required|date',
            'details' => 'nullable|string',
            'placement_amount' => 'required|numeric|min:0',
            'fund_transfer_amount' => 'nullable|numeric|min:0',
            'prepared_by' => 'nullable|string|max:255',
            'reviewed_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }
}
