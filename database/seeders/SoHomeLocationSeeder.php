<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoHomeLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [

            [
                'so_id' => 'SO-001',
                'home_lat' => 9.9252,
                'home_long' => 78.1198,
                'home_address' => 'No 21, Big Bazaar Street, Madurai',
            ],

            [
                'so_id' => 'SO-002',
                'home_lat' => 8.0883,
                'home_long' => 77.5385,
                'home_address' => 'No 7, Beach Road, Nagercoil',
            ],

        ];

        foreach ($locations as $location) {

            $exists = DB::table('so_home_locations')
                ->where('so_id', $location['so_id'])
                ->exists();

            if (! $exists) {

                DB::table('so_home_locations')->insert(array_merge($location, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));

            }

        }
    }
}
