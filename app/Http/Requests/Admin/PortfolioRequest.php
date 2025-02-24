<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Residential,Commercial,Mixed-Use',
            'description' => 'required|string',
            'foundation_date' => 'required|date',
            'total_assets' => 'required|numeric|min:0',
            'market_cap' => 'required|numeric|min:0',
            'available_funds' => 'required|numeric|min:0',
            'management_company' => 'required|string|max:255',
            'legal_entity_type' => 'required|string|in:LLC,Corporation,Partnership',
            'tax_id' => 'required|string|max:20',
            'currency' => 'required|string|size:3',
            'risk_profile' => 'required|string|in:Low,Medium,High',
            'target_return' => 'required|numeric|between:0,100',
            'investment_strategy' => 'required|string|max:255',
            'portfolio_manager' => 'required|string|max:255',
            'fiscal_year_end' => 'required|date',
            'active_status' => 'boolean'
        ];
    }
}
