<?php

namespace App\Repositories\Interfaces;

interface DealerMappingRepositoryInterface extends BaseRepositoryInterface
{
    public function buildHierarchyTree(): array;

    public function validateHierarchyOrder(int $parentId, int $childId): ?string;

    public function createUserMapping(int $parentId, int $childId);
}
