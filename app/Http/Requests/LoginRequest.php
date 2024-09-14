<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Validator;

/**
 * @property string $email
 * @property  string $password
 */
class LoginRequest extends FormRequest
{
    private ?User $_user = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->count() > 0) return;
                $this->_user = User::where('email', $this->email)->first();
                if ($this->_user === null || !Hash::check($this->password, $this->_user->password)) {
                    $validator->errors()->add(
                        'password',
                        'Invalid email or password'
                    );
                    return;
                }
                if ($this->_user->status === UserStatus::BANNED) {
                    $validator->errors()->add(
                        'email',
                        'Your account is banned until ' . $this->_user->banned_to
                    );
                    return;
                }
                if ($this->_user->status === UserStatus::DELETED) {
                    $validator->errors()->add(
                        'email',
                        'Your account is permanently blocked'
                    );
                }
                if (!$this->_user->hasVerifiedEmail()) {
                    $validator->errors()->add(
                        'email',
                        'You must verify email before login'
                    );
                }
            }
        ];
    }

    public function getUserModel(): User|null
    {
        return $this->_user;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'bail|required|exists:users,email',
            'password' => 'bail|required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Input your email',
            'email.exists' => 'User with this email is not found',
            'password.required' => 'Input your password',
        ];
    }
}
