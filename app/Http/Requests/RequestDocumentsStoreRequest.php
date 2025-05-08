<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestDocumentsStoreRequest extends FormRequest
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
            'list_security_id' => 'required|exists:list_securities,id',
            'purpose' => 'nullable|string|max:255',
            'request_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'withdrawal_date' => 'nullable|date',
            'return_date' => 'nullable|date',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
        ];
    }
}
