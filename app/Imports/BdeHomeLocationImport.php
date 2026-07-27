<?php

namespace App\Imports;

use App\Models\BdeHomeLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BdeHomeLocationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new BdeHomeLocation([

            'bde_id'       => $row['bde_id'],

            'home_lat'     => $row['home_lat'],

            'home_long'    => $row['home_long'],

            'home_address' => $row['home_address'],

        ]);
    }
}