<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getByRoleName(string $roleName);

    public function getByRoleId(int $roleId);
}
