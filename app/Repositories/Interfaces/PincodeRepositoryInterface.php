<?php

namespace App\Repositories\Interfaces;

interface PincodeRepositoryInterface extends BaseRepositoryInterface
{
    public function getByCity(int $cityId);
}
