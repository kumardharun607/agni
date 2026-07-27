<?php

namespace App\Repositories\Eloquent;

use App\Models\PermissionDropdown;
use App\Repositories\Interfaces\PermissionDropdownRepositoryInterface;

class PermissionDropdownRepository extends BaseRepository implements PermissionDropdownRepositoryInterface
{
    public function __construct(PermissionDropdown $model)
    {
        parent::__construct($model);
    }
}
