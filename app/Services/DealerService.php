<?php

namespace App\Services;

use App\Repositories\Interfaces\DealerRepositoryInterface;

class DealerService extends BaseService
{
    public function __construct(DealerRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getParentCandidates(?int $excludeId = null)
    {
        return $this->repository->getParentCandidates($excludeId);
    }
}
