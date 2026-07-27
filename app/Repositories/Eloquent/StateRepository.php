<?php

namespace App\Repositories\Eloquent;

use App\Models\State;
use App\Repositories\Interfaces\StateRepositoryInterface;

class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    public function __construct(State $model)
    {
        parent::__construct($model);
    }

    public function getByCountry(int $countryId)
    {
        return $this->model->where('country_id', $countryId)->orderBy('name')->get(['id', 'name']);
    }
}
