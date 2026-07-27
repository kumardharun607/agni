<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CityImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new City([

            'country_id' => $row['country_id'],

            'state_id' => $row['state_id'],

            'city_name' => $row['city_name'],

            'status' => $row['status'] ?? 1,

        ]);
    }
}