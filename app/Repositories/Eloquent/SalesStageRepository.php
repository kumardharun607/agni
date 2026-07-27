<?php

namespace App\Repositories\Eloquent;

use App\Models\SalesStage;
use App\Repositories\Interfaces\SalesStageRepositoryInterface;

class SalesStageRepository extends BaseRepository implements SalesStageRepositoryInterface
{
    public function __construct(SalesStage $model)
    {
        parent::__construct($model);
    }
}
