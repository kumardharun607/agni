<?php

namespace App\Imports;

use App\Models\SoHomeLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoHomeLocationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new SoHomeLocation([

            'so_id'        => $row['so_id'],

            'home_lat'     => $row['home_lat'],

            'home_long'    => $row['home_long'],

            'home_address' => $row['home_address'],

        ]);
    }
}