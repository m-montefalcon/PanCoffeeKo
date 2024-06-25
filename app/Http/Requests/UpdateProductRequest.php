<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest

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
            'id' => ['required', 'exists:products,id'],
            'name' => [
                'nullable', 'max:255',
                Rule::unique('products')->ignore($this->id, 'id')
            ],
            'description' => ['nullable', 'max:255'],
            'price' => [
                'nullable',
                'decimal:0,2'
            ],
            'quantity' => ['nullable', 'integer'],
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id']
        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'The product ID is required.',
            'id.exists' => 'The selected product ID is invalid.',

            'name.max' => 'The product name cannot be longer than 255 characters.',
            'name.unique' => 'The product name has already been taken.',

            'description.max' => 'The product description cannot be longer than 255 characters.',

            'price.decimal' => 'The price must be a valid decimal number with up to 2 decimal places.',

            'quantity.integer' => 'The quantity must be an integer value.',

            'product_category_id.exists' => 'The selected product category is invalid.',

            'supplier_id.exists' => 'The selected supplier is invalid.',
        ];
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();
        throw new HttpResponseException(response()->json([
            'message' => $errors,
            'errors' => $validator->errors(),
        ], 422));
    }
}
