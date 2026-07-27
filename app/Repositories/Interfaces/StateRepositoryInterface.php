<?php

namespace App\Repositories\Interfaces;

interface StateRepositoryInterface extends BaseRepositoryInterface
{
    public function getByCountry(int $countryId);
}
