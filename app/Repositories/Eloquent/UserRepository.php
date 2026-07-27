<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getByRoleName(string $roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (! $role) {
            return collect();
        }

        return $this->getByRoleId($role->id);
    }

    public function getByRoleId(int $roleId)
    {
        return $this->model->where('role_id', $roleId)->orderBy('name')->get();
    }
}
