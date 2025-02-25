<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'portfolio_id' => 'required|exists:portfolios,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'property_type' => 'required|string|in:Apartment,Office,Retail,Mixed-Use',
            'square_footage' => 'required|numeric|min:0',
            'land_area' => 'required|numeric|min:0',
            'year_built' => 'required|integer|min:1800|max:' . date('Y'),
            'purchase_price' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'expected_roi' => 'required|numeric|between:0,100',
            'acquisition_date' => 'required|date',
            'zoning_type' => 'required|string|max:50',
            'building_class' => 'required|string|in:A,B,C',
            'number_of_floors' => 'required|integer|min:1',
            'parking_spaces' => 'required|integer|min:0',
            'primary_use' => 'required|string|max:255',
            'occupancy_rate' => 'required|numeric|between:0,100',
            'property_manager' => 'required|string|max:255',
            'insurance_details' => 'required|string',
            'tax_parcel_id' => 'required|string|max:255|unique:properties,tax_parcel_id,' . $this->property?->id,
            'last_renovation_date' => 'nullable|date',
            'status' => 'required|string|in:Active,Under Renovation,For Sale',
            'annual_property_tax' => 'required|numeric|min:0',
            'insurance_cost' => 'required|numeric|min:0'
        ];
    }
}
