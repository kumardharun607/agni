<?php

namespace App\Services;

use App\Repositories\Interfaces\StateRepositoryInterface;

class StateService extends BaseService
{
    public function __construct(StateRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getByCountry(int $countryId)
    {
        return $this->repository->getByCountry($countryId);
    }
}
