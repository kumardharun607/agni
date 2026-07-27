<?php

namespace App\Imports;

use App\Models\Pincode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PincodeImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Pincode([

            'city_id'       => $row['city_id'],

            'pincode'       => $row['pincode'],

            'area_name'     => $row['area_name'],

            'status'        => $row['status'] ?? 1,

        ]);
    }
}