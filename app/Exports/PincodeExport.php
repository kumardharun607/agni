<?php

namespace App\Exports;

use App\Models\Pincode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PincodeExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pincode::with('city.state.country')->orderBy('pincode')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Country', 'State', 'City', 'Pincode', 'City ID', 'Created At', 'Updated At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->city->state->country->name ?? '',
            $row->city->state->name ?? '',
            $row->city->name ?? '',
            $row->pincode,
            $row->city_id,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
