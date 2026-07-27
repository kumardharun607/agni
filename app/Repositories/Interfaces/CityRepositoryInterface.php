<?php

namespace App\Repositories\Interfaces;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function getByState(int $stateId);
}
