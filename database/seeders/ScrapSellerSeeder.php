<?php

namespace Database\Seeders;

use App\Models\ScrapSeller;
use Illuminate\Database\Seeder;

class ScrapSellerSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = [

            [
                'alies_id' => 'ALS-001',
                'company_name' => 'Murugan Scrap Mart',
                'business_age' => '5',
                'owner_name' => 'Murugan S',
                'mobile' => '9000000001',
                'owner_type' => 'Owner',
                'address' => 'No 8, Market Road, Coimbatore',
                'gst_no' => '33CCCCC2222C1Z5',
                'pan_no' => 'CCCCC2222C',
                'email' => 'murugan.scrap@example.com',
                'total_ton' => 12,
                'approval' => 'Approved',
                'cdate' => now(),
            ],

            [
                'alies_id' => 'ALS-002',
                'company_name' => 'Lakshmi Iron Traders',
                'business_age' => '3',
                'owner_name' => 'Lakshmi Narayanan',
                'mobile' => '9000000002',
                'owner_type' => 'Owner',
                'address' => 'No 21, Big Bazaar Street, Madurai',
                'gst_no' => '33DDDDD3333D1Z5',
                'pan_no' => 'DDDDD3333D',
                'email' => 'lakshmi.iron@example.com',
                'total_ton' => 8,
                'approval' => 'Pending',
                'cdate' => now(),
            ],

        ];

        foreach ($sellers as $seller) {

            ScrapSeller::firstOrCreate(
                ['mobile' => $seller['mobile']],
                $seller
            );

        }
    }
}
