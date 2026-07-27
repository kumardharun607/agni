<?php

namespace App\Services;

use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryService extends BaseService
{
    public function __construct(CountryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
