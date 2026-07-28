<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\PermissionDropdown;
use App\Models\Role;
use App\Models\RolePermission;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService
    ) {
    }

    // Roles & Permissions matrix page: pick a role, tick view/add/edit/delete per feature
    public function index()
    {
        $roles = $this->roleService->getAllOrderedByLevel();

        return view('permissions.index', compact('roles'));
    }

    // Only the Admin (super admin) role itself may ever view/edit the Admin role's
    // own permission row. Every other role is blocked, even if they otherwise have
    // permission-edit access.
    private function guardSuperAdminRole(Role $role): void
    {
        // Admin always has full access — no role (including Admin itself) may change it.
        if (strcasecmp($role->name, 'Admin') === 0) {
            abort(403, 'Admin role permissions cannot be modified. Admin always has full access to all features.');
        }
    }

    public function edit(Role $role)
    {
        $this->guardSuperAdminRole($role);

        $features = PermissionDropdown::orderBy('name')->get();
        $existing = RolePermission::where('role_id', $role->id)->get()->keyBy('permission_dropdown_id');

        return view('permissions.edit', compact('role', 'features', 'existing'));
    }

    public function update(Request $request, Role $role)
    {
        $this->guardSuperAdminRole($role);

        $permissions = $request->input('permissions', []); // [feature_id => ['view'=>on,'add'=>on,...]]

        foreach ($permissions as $featureId => $flags) {
            RolePermission::updateOrCreate(
                ['role_id' => $role->id, 'permission_dropdown_id' => $featureId],
                [
                    'can_view' => isset($flags['view']),
                    'can_add' => isset($flags['add']),
                    'can_edit' => isset($flags['edit']),
                    'can_delete' => isset($flags['delete']),
                    'can_import' => isset($flags['import']),
                    'can_export' => isset($flags['export']),
                ]
            );
        }

        // any feature left out of the submitted payload entirely = no access at all
        RolePermission::where('role_id', $role->id)
            ->whereNotIn('permission_dropdown_id', array_keys($permissions))
            ->delete();

        // Clear cached permission checks so the role sees changes immediately
        foreach (['view','add','edit','delete','import','export'] as $ability) {
            foreach (PermissionDropdown::pluck('name') as $fname) {
                Cache::forget("perm_{$role->id}_{$fname}_{$ability}");
            }
        }

        $message = 'Permissions updated for ' . $role->name . '.';
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'redirect' => route('permissions.index')]);
        }

        return redirect()->route('permissions.index')->with('success', $message);
    }
}
