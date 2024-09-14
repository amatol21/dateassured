<?php

namespace App\Http\Requests\Admin;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $second_name
 * @property int $age
 * @property int $gender
 * @property int $sexuality
 * @property int $role_id
 */
class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return User::current() !== null
            && User::current()->hasPermission(Permission::MANAGE_USERS);
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->count() > 0) return;
                if ($this->has('id')) {
                    $existingUser = User::where('email', $this->post('email'))->first();
                    if ($existingUser !== null && !$existingUser->id == $this->post('id')) {
                        $validator->errors()->add('email', 'Email already taken.');
                        return;
                    }
                    $existingUser = User::where('username', $this->post('username'))->first();
                    if ($existingUser !== null && !$existingUser->id == $this->post('id')) {
                        $validator->errors()->add('username', 'Username already taken.');
                    }
                } else {
                    $existingUser = User::where('email', $this->post('email'))->first();
                    if ($existingUser !== null) {
                        $validator->errors()->add('email', 'Email already taken.');
                        return;
                    }

                    $existingUser = User::where('username', $this->post('username'))->first();
                    if ($existingUser !== null) {
                        $validator->errors()->add('username', 'Username already taken.');
                    }
                }
            }
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'email' => 'required',
            'first_name' => 'required',
            'second_name' => 'required',
            'gender' => 'required',
            'sexuality' => 'required',
            'age' => 'required',
        ];
    }
}
