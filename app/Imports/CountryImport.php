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
        if (! $name) {
            return null;
        }

        $name = trim($name);

        // Skip live duplicates (controller import handles the custom message path)
        if (Country::where('name', $name)->exists()) {
            return null;
        }

        $trashed = Country::onlyTrashed()->where('name', $name)->first();
        if ($trashed) {
            $trashed->restore();
            $trashed->update(['code' => $row['code'] ?? null]);

            return null;
        }

        return new Country([
            'name' => $name,
            'code' => $row['code'] ?? null,
        ]);
    }
}
