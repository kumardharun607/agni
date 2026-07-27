<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthService
{
    public function __construct(
        private readonly AuthRepositoryInterface $repository
    ) {
    }

    public function login(array $data): bool
    {
        return $this->repository->login($data);
    }

    public function logout(): void
    {
        $this->repository->logout();
    }
}
