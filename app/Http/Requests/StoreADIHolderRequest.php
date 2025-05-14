<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreADIHolderRequest extends FormRequest
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
            // 'facility_information_id' => 'required|exists:facility_informations,id',
            'adi_holder' => 'required|string|max:255',
            'stock_codes' => 'required|array|min:1',
            'stock_codes.*' => 'required|string|max:50',
            'nominal_values' => 'required|array|min:1',
            'nominal_values.*' => 'required|numeric|min:0',
        ];
    }
}
