<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Implement authorization logic if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'exists:users,id'],
            'name' => ['nullable', 'max:255'],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($this->userId, 'id'),
            ],
            'contact_number' => ['nullable', 'size:11',
            Rule::unique('users')->ignore($this->userId, 'id'),
        ],
            'role' => ['nullable'],
            'password' => ['nullable', 'min:8'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'userId.required' => 'User ID (UUID) is required.',
            'userId.exists' => 'Invalid user ID (UUID) provided.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'contact_number.size' => 'The contact number must be exactly 11 characters.',
            'password.min' => 'The password must be at least 8 characters.',
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
