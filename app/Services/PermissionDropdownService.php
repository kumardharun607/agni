<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionDropdownRepositoryInterface;

class PermissionDropdownService extends BaseService
{
    public function __construct(PermissionDropdownRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
