<?php

namespace App\Services;

use App\Repositories\Interfaces\DealerMappingRepositoryInterface;

class DealerMappingService extends BaseService
{
    public function __construct(DealerMappingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function buildHierarchyTree(): array
    {
        return $this->repository->buildHierarchyTree();
    }

    public function validateHierarchyOrder(int $parentId, int $childId): ?string
    {
        return $this->repository->validateHierarchyOrder($parentId, $childId);
    }

    public function createUserMapping(int $parentId, int $childId)
    {
        return $this->repository->createUserMapping($parentId, $childId);
    }
}
