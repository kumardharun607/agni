<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    protected $repository;

    public function __construct(
        PermissionRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function update(
        Role $role,
        array $permissions
    )
    {
        DB::transaction(function () use (
            $role,
            $permissions
        ) {

            $this->repository->sync(
                $role,
                $permissions
            );

        });
    }
}