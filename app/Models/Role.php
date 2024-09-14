<?php

namespace App\Models;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $permissions
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends Model
{
    private ?array $_permissions = null;

    public function hasPermission(Permission $permission): bool
    {
        if ($this->_permissions === null) {
            $this->_permissions = explode(',', $this->permissions);
        }
        return in_array($permission->value, $this->_permissions) || in_array('all', $this->_permissions);
    }

    /**
     * @return Role[]|Collection
     */
    public static function allRoles(): Collection|array
    {
        return Role::orderBy('name', 'asc')->get();
    }
}
