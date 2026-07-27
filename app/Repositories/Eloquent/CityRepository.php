<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function getByState(int $stateId)
    {
        return $this->model->where('state_id', $stateId)->orderBy('name')->get(['id', 'name']);
    }
}
