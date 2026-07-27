<?php

namespace App\Repositories\Eloquent;

use App\Models\Pincode;
use App\Repositories\Interfaces\PincodeRepositoryInterface;

class PincodeRepository extends BaseRepository implements PincodeRepositoryInterface
{
    public function __construct(Pincode $model)
    {
        parent::__construct($model);
    }

    public function getByCity(int $cityId)
    {
        return $this->model->where('city_id', $cityId)->orderBy('pincode')->get(['id', 'pincode']);
    }
}
