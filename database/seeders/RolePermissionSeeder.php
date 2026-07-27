<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [

            'dashboard',

            'country-list',
            'country-create',
            'country-edit',
            'country-delete',

            'state-list',
            'state-create',
            'state-edit',
            'state-delete',

            'city-list',
            'city-create',
            'city-edit',
            'city-delete',

            'pincode-list',
            'pincode-create',
            'pincode-edit',
            'pincode-delete',

            'scrap-distributor-list',
            'scrap-distributor-create',
            'scrap-distributor-edit',
            'scrap-distributor-delete',

            'scrap-seller-list',
            'scrap-seller-create',
            'scrap-seller-edit',
            'scrap-seller-delete',

            'bde-home-location-list',
            'bde-home-location-create',
            'bde-home-location-edit',
            'bde-home-location-delete',

            'so-home-location-list',
            'so-home-location-create',
            'so-home-location-edit',
            'so-home-location-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',

        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);

        }

        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $role->syncPermissions(Permission::all());
    }
}