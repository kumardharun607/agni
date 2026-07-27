<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;

class CityService extends BaseService
{
    public function __construct(CityRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getByState(int $stateId)
    {
        return $this->repository->getByState($stateId);
    }
}
