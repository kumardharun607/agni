<?php

namespace App\Imports;

use App\Models\ScrapSeller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ScrapSellerImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        return new ScrapSeller([

            'rep_id' => $row['rep_id'] ?? null,

            'name' => $row['name'],

            'customer_name' => $row['customer_name'],

            'mobile' => $row['mobile'],

            'country_id' => $row['country_id'],

            'state_id' => $row['state_id'],

            'city_id' => $row['city_id'],

            'pincode_id' => $row['pincode_id'],

            'address' => $row['address'],

            'gst_no' => $row['gst_no'] ?? null,

            'pan_no' => $row['pan_no'] ?? null,

            'email' => $row['email'] ?? null,

            'latitude' => $row['latitude'] ?? null,

            'longitude' => $row['longitude'] ?? null,

            'dob' => $row['dob'] ?? null,

            'date' => $row['date'] ?? null,

        ]);

    }

}