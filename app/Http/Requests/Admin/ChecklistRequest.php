<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChecklistRequest extends FormRequest
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
            'type' => 'required|string|in:Move-in,Move-out,Inspection,Maintenance',
            'description' => 'nullable|string',
            'is_template' => 'boolean',
            'sections' => 'required|json',
            'active' => 'boolean',
            'items' => 'required|array',
            'items.*.section' => 'required|string|max:255',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.type' => 'required|string|in:Boolean,Number,Text,Rating',
            'items.*.options' => 'nullable|json',
            'items.*.required' => 'boolean',
            'items.*.order' => 'required|integer|min:0'
        ];
    }
}
