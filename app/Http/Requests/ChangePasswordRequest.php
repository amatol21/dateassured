<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

/**
 * @property string $new_password
 */
class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->count() > 0) return;
                /** @var User $user */
                $user = Auth::user();
                if ($user->password !== User::DUMMY_PASSWORD) {
                    $password = trim($this->post('current_password', ''));
                    if ($password === '') {
                        $validator->errors()->add('current_password', 'Input your current password');
                        return;
                    }
                    if (!Hash::check($password, $user->password)) {
                        $validator->errors()->add('password', 'Password is invalid.');
                    }
                }
            }
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'new_password' => 'required|confirmed',
        ];
    }
}
