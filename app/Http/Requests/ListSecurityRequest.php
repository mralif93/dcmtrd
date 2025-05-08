<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListSecurityRequest extends FormRequest
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
            'security_name' => ['required', 'string', 'max:255'],
            'security_code' => ['required', 'string', 'max:255'],
            'asset_name_type' => ['required', 'in:Land Property,Charge,Policy Insurance'],
            'issuer_id' => ['required', 'exists:issuers,id'],
            'status' => ['nullable', 'string', 'max:255'],
            'prepared_by' => ['nullable', 'string', 'max:255'],
            'verified_by' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'approval_datetime' => ['nullable', 'date'],
        ];
    }
}
