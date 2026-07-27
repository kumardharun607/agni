<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BdeHomeLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [

            [
                'bde_id' => 'BDE-001',
                'home_lat' => 13.0827,
                'home_long' => 80.2707,
                'home_address' => 'No 12, Anna Nagar, Chennai',
            ],

            [
                'bde_id' => 'BDE-002',
                'home_lat' => 11.0168,
                'home_long' => 76.9558,
                'home_address' => 'No 45, RS Puram, Coimbatore',
            ],

        ];

        foreach ($locations as $location) {

            $exists = DB::table('bde_home_locations')
                ->where('bde_id', $location['bde_id'])
                ->exists();

            if (! $exists) {

                DB::table('bde_home_locations')->insert(array_merge($location, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));

            }

        }
    }
}
