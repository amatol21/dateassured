<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $email
 * @property string $password
 */
class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'bail|required|unique:users,email',
            'password' => ['bail', 'required', 'confirmed', Password::min(6)],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Input your email.',
            'email.unique' => 'User with such email already exists.',
            'password.required' => 'Input your password',
            'password.confirmed' => "Passwords doesn't match.",
        ];
    }
}
