<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $name = $row['name'] ?? $row['country_name'] ?? null;
        if (!$name) {
            return null;
        }

        return Country::updateOrCreate(
            ['name' => $name],
            ['code' => $row['code'] ?? null]
        );
    }
}
