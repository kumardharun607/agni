<?php

namespace App\Services;

use App\Repositories\Interfaces\PincodeRepositoryInterface;

class PincodeService extends BaseService
{
    public function __construct(PincodeRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getByCity(int $cityId)
    {
        return $this->repository->getByCity($cityId);
    }
}
