<?php

namespace App\Repositories\Eloquent;

use App\Models\Dealer;
use App\Repositories\Interfaces\DealerRepositoryInterface;

class DealerRepository extends BaseRepository implements DealerRepositoryInterface
{
    public function __construct(Dealer $model)
    {
        parent::__construct($model);
    }

    public function getParentCandidates(?int $excludeId = null)
    {
        $query = $this->model
            ->whereIn('client_type', [Dealer::TYPE_EXISTING, Dealer::TYPE_NEW])
            ->orderBy('name');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
    }
}
