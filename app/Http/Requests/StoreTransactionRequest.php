<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTransactionRequest extends FormRequest
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
            'id' => ['required'],
            'total_amount' => ['required', 'decimal:0,2'],
            'received_amount' => ['required', 'decimal:0,2'],
            'change_amount' => ['required', 'decimal:0,2'],
            'user_id' => ['required', 'exists:users,id'],

        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'The id field is required.',

            'total_amount.required' => 'The total amount field is required.',
            'total_amount.decimal' => 'The total amount must be a valid number with up to 2 decimal places.',

            'received_amount.required' => 'The received amount field is required.',
            'received_amount.decimal' => 'The received amount must be a valid number with up to 2 decimal places.',

            'change_amount.required' => 'The change amount field is required.',
            'change_amount.decimal' => 'The change amount must be a valid number with up to 2 decimal places.',

            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user does not exist.'
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
