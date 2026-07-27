<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService extends BaseService
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getByRoleName(string $roleName)
    {
        return $this->repository->getByRoleName($roleName);
    }

    public function getByRoleId(int $roleId)
    {
        return $this->repository->getByRoleId($roleId);
    }
}
