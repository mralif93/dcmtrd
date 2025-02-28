<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChecklistItemRequest extends FormRequest
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
        $checklist = $this->route('checklist');
        
        return [
            'item_name' => 'required|string|max:255',
            'section' => [
                'required',
                'string',
                Rule::in($checklist->sections),
            ],
            'description' => 'nullable|string',
            'type' => 'required|string|in:Boolean,Text,Number,Rating',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'required' => 'boolean',
            'order' => 'integer|min:0',
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert the boolean checkbox to proper boolean value
        $this->merge([
            'required' => $this->has('required'),
        ]);
    }
}
