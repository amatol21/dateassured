<?php

namespace App\Http\Requests;

use App\Enums\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

/**
 * @property int $id
 * @property string $name
 * @property array $permissions
 */
class SaveRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && User::current()->hasPermission(Permission::MANAGE_ROLES);
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->count() > 0) return;
                if (!$this->has('id')) {
                    $existingUser = Role::where('name', $this->post('name'))->first();
                    if ($existingUser !== null) {
                        $validator->errors()->add('name', 'Role with this name already exists.');
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
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Input name of the role.',
        ];
    }
}
