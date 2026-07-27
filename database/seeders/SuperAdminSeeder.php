<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => 'admin@agni.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Agni@123'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('Super Admin');
    }
}