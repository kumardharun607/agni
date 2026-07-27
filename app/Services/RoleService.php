<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService extends BaseService
{
    public function __construct(RoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getAllOrderedByLevel()
    {
        return $this->repository->getAllOrderedByLevel();
    }

    public function findByName(string $name)
    {
        return $this->repository->findByName($name);
    }
}
