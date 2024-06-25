<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'id' => ['required', 'exists:suppliers,id'],
            'name' => ['nullable', 'max:255'],
            
            'contact_number' => [
                'nullable', 'size:11',
                Rule::unique('suppliers')->ignore($this->id, 'id'),
            ],
            'supply_type' => ['nullable', 'max:255'],

        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'User ID (UUID) is required.',
            'id.exists' => 'Invalid user ID (UUID) provided.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'contact_number.size' => 'The contact number must be exactly 11 characters.',
            'contact_number.unique' => 'The contact number already exist',
            'supply_type.max' => 'The supply type may not be greater than 255 characters.',

        ];
    }
}
