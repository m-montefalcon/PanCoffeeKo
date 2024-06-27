<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'received_amount' => ['required', 'decimal:0,2'],
            'total_amount' => ['required', 'decimal:0,2'],
            'change_amount' => ['required', 'decimal:0,2'],

            'products' => ['required', 'array'],
            'product.*.id' => ['required', 'exists:products,id'], 
            'product.*.quantity' => ['required', 'integer', 'min:1'], 
            'product.*.price' => ['required', 'decimal:0,2'], 


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

}
