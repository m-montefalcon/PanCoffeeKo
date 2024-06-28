<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidateProductQuantity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTransactionDetailRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'received_amount' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'change_amount' => ['required', 'numeric', 'min:0'],

            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.product_quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    // Extract the index from the attribute name
                    $index = explode('.', $attribute)[1];
                    $productId = $this->input("products.$index.product_id");

                    // Query the database for the quantity of the product
                    $qty = DB::table('products')->where('id', $productId)->value('quantity');

                    if ($value > $qty) {
                        $fail("$attribute cannot be more than available quantity ($qty).");
                    }
                },
            ],
            'products.*.product_price' => ['required', 'numeric', 'min:0'],
        ];
    }



    
    
    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
            
            'received_amount.required' => 'The received amount is required.',
            'received_amount.decimal' => 'The received amount must be a valid number with up to 2 decimal places.',

            'total_amount.required' => 'The total amount is required.',
            'total_amount.decimal' => 'The total amount must be a valid number with up to 2 decimal places.',

            'change_amountrequired' => 'The change amount is required.',
            'change_amount.decimal' => 'The change amount must be a valid number with up to 2 decimal places.',


            'products.required' => 'At least one product is required.',
            'products.array' => 'The products must be an array.',

            'product.*.id.required' => 'The product ID is required for all products.',
            'product.*.id.exists' => 'A selected product does not exist in our records.',

            'product.*.quantity.required' => 'The quantity is required for all products.',
            'product.*.quantity.integer' => 'The quantity must be a whole number.',
            'product.*.quantity.min' => 'The quantity must be at least 1.',
           
            'product.*.price.required' => 'The price is required for all products.',
            'product.*.price.decimal' => 'The product price must be a valid number with up to 2 decimal places.',


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
