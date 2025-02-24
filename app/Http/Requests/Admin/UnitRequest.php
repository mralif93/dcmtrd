<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'unit_number' => 'required|string|max:50',
            'unit_type' => 'required|string|in:Studio,1BR,2BR,3BR',
            'square_footage' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'ceiling_height' => 'required|numeric|min:0',
            'floor_type' => 'required|string|max:255',
            'furnished' => 'boolean',
            'view_type' => 'required|string|max:255',
            'base_rent' => 'required|numeric|min:0',
            'exposure' => 'required|string|in:North,South,East,West',
            'floor_number' => 'required|integer|min:0',
            'pets_allowed' => 'boolean',
            'washer_dryer' => 'boolean',
            'parking_included' => 'boolean',
            'heating_type' => 'required|string|max:255',
            'cooling_type' => 'required|string|max:255',
            'appliances_included' => 'required|json',
            'last_renovation' => 'nullable|date',
            'condition' => 'required|string|in:Excellent,Good,Fair,Poor',
            'status' => 'required|string|in:Available,Occupied,Maintenance',
            'utility_cost' => 'required|numeric|min:0'
        ];
    }
}
