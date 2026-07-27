<?php

namespace App\Imports;

use App\Models\ScrapDistributor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ScrapDistributorImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $name = $row['name'] ?? null;
        if (! $name) {
            return null;
        }

        return new ScrapDistributor([
            'rep_id' => $row['rep_id'] ?? null,
            'name' => $name,
            'customer_name' => $row['customer_name'] ?? $name,
            'mobile' => $row['mobile'] ?? $row['mobile_number'] ?? null,
            'country_id' => $row['country_id'] ?? null,
            'state_id' => $row['state_id'] ?? null,
            'city_id' => $row['city_id'] ?? null,
            'pincode_id' => $row['pincode_id'] ?? null,
            'address' => $row['address'] ?? '',
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
