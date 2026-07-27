<?php

use App\Models\PermissionDropdown;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (!function_exists('userCan')) {
    // Checks whether the logged-in user's role has an ability (view/add/edit/delete) on a feature.
    // Used both in Blade (@userCan) to hide/show buttons and in the CheckPermission middleware.
    function userCan(string $feature, string $ability): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        $key = "perm_{$user->role_id}_{$feature}_{$ability}";

        return Cache::remember($key, 300, function () use ($user, $feature, $ability) {
            $featureRow = PermissionDropdown::where('name', $feature)->first();
            if (!$featureRow) return false;

            $column = 'can_' . $ability;
            return RolePermission::where('role_id', $user->role_id)
                ->where('permission_dropdown_id', $featureRow->id)
                ->where($column, true)
                ->exists();
        });
    }
}


if (!function_exists('clearRolePermissionCache')) {
    function clearRolePermissionCache(?int $roleId = null): void
    {
        if ($roleId) {
            foreach (\App\Models\PermissionDropdown::pluck('name') as $fname) {
                foreach (['view','add','edit','delete','import','export'] as $ability) {
                    \Illuminate\Support\Facades\Cache::forget("perm_{$roleId}_{$fname}_{$ability}");
                }
            }
        } else {
            \Illuminate\Support\Facades\Cache::flush();
        }
    }
}
