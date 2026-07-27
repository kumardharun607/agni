<?php

namespace App\Repositories\Interfaces;

interface DealerRepositoryInterface extends BaseRepositoryInterface
{
    public function getParentCandidates(?int $excludeId = null);
}
