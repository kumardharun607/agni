<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Pincode;
use App\Models\ScrapDistributor;
use App\Models\State;
use Illuminate\Database\Seeder;

class ScrapDistributorSeeder extends Seeder
{
    public function run(): void
    {
        // Minimal master data required for the foreign keys on scrap_distributors

        $country = Country::firstOrCreate(
            ['country_name' => 'India'],
            ['status' => 1]
        );

        $state = State::firstOrCreate(
            ['state_name' => 'Tamil Nadu', 'country_id' => $country->id],
            ['status' => 1]
        );

        $city = City::firstOrCreate(
            ['city_name' => 'Chennai', 'state_id' => $state->id],
            ['status' => 1]
        );

        $pincode = Pincode::firstOrCreate(
            ['pincode' => '600001', 'city_id' => $city->id],
            ['status' => 1]
        );

        $distributors = [

            [
                'rep_id' => 'REP-001',
                'name' => 'Kavin Traders',
                'customer_name' => 'Kavin Kumar',
                'mobile' => '9876543210',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'pincode_id' => $pincode->id,
                'address' => 'No 12, Anna Nagar, Chennai',
                'gst_no' => '33AAAAA0000A1Z5',
                'pan_no' => 'AAAAA0000A',
                'email' => 'kavin.traders@example.com',
                'date' => now(),
            ],

            [
                'rep_id' => 'REP-002',
                'name' => 'Sri Balaji Scrap Distributors',
                'customer_name' => 'Balaji Raman',
                'mobile' => '9876543211',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'pincode_id' => $pincode->id,
                'address' => 'No 45, T Nagar, Chennai',
                'gst_no' => '33BBBBB1111B1Z5',
                'pan_no' => 'BBBBB1111B',
                'email' => 'sribalaji.scrap@example.com',
                'date' => now(),
            ],

        ];

        foreach ($distributors as $distributor) {

            ScrapDistributor::firstOrCreate(
                ['mobile' => $distributor['mobile']],
                $distributor
            );

        }
    }
}
