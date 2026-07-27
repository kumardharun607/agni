<?php
namespace Database\Seeders;

use App\Models\PermissionDropdown;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // hierarchy: 1 Telecaller, 2 Manager, 3 SO, 4 BDE — plus Admin for the backend
        $roles = [
            'Admin' => null,
            'Telecaller' => 1,
            'Manager' => 2,
            'SO' => 3,
            'BDE' => 4,
        ];
        foreach ($roles as $name => $level) {
            Role::firstOrCreate(['name' => $name], ['level' => $level]);
        }

        $features = [
            'Countries', 'States', 'Cities', 'Pincodes',
            'Dealer', 'Mapping', 'Users', 'Permission Dropdown', 'Sales Stage',
            // ported from sharvin_agni
            'ScrapDistributor', 'ScrapSeller', 'BdeHomeLocation', 'SoHomeLocation',
            // ported from selva_agni
            'Brands', 'Floor Stage', 'Building Stage', 'Dealer Registration',
            'Roles', 'Permissions',
        ];
        foreach ($features as $f) {
            PermissionDropdown::firstOrCreate(['name' => $f]);
        }

        // Admin gets full access to every feature
        $admin = Role::where('name', 'Admin')->first();
        foreach (PermissionDropdown::all() as $feature) {
            RolePermission::updateOrCreate(
                ['role_id' => $admin->id, 'permission_dropdown_id' => $feature->id],
                ['can_view' => true, 'can_add' => true, 'can_edit' => true, 'can_delete' => true, 'can_import' => true, 'can_export' => true]
            );
        }

        User::firstOrCreate(
            ['email' => 'admin@agnisteels.test'],
            [
                'emp_code' => 'ADM-001',
                'role_id' => $admin->id,
                'name' => 'Super Admin',
                'mobile' => '9999999999',
                'plain_password' => 'password',
            ]
        );
    }
}
