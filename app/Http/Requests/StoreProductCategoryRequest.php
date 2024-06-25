<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductCategoryRequest extends FormRequest
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
            'name' => ['required', 'unique:product_categories,name', 'max:255']
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field must be required',
            'name.unique' => 'The name already exist',
            'name.max' => 'The name may not be greater than 255 characters.',

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
