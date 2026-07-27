<?php

namespace App\Imports;

use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StateImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new State([

            'country_id' => $row['country_id'],

            'state_name' => $row['state_name'],

            'status' => $row['status'] ?? 1,

        ]);
    }
}