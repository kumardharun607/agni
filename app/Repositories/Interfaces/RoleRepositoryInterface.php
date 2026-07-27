<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllOrderedByLevel();

    public function findByName(string $name);
}
