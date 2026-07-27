<?php

namespace App\Services;

use App\Repositories\Interfaces\SalesStageRepositoryInterface;

class SalesStageService extends BaseService
{
    public function __construct(SalesStageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
