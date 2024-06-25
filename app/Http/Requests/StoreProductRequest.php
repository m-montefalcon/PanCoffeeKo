<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'unique:products,name', 'max:255'],
            'description' => ['required', 'max:255'],
            'price' => [
                'required',
                'decimal:0,2'
            ],
            'quantity' => ['required', 'integer'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'supplier_id' => ['required', 'exists:suppliers,id']
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name already exist.',
            'name.max' => 'The name may not be greater than :255 characters.',

            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 255 characters.',

            'price.required' => 'The price field is required.',
            'price.decimal' => 'The price must be a valid decimal number with up to 2 decimal places.',

            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be a valid integer.',

            'product_category_id.required' => 'The product category is required.',
            'product_category_id.exists' => 'The selected product category is invalid.',

            'supplier_id.required' => 'The supplier is required.',
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
