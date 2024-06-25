<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductCategoryRequest extends FormRequest
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
            'id' => ['required', 'exists:product_categories,id'],
            'name' => [
                'required',
                Rule::unique('product_categories')->ignore($this->id, 'id'),
                'max:255'
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'The UUID is required ',
            'id.exist' => 'The UUID is not valid and does not exist',
            'name.required' => 'The name field should be required',
            'name.unique' => 'The name already exist',
            'name.max' => 'The name may not be greater than 255 characters.'

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
