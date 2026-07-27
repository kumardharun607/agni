<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CityExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return City::with('state')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'State', 'State ID', 'Created At', 'Updated At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->state->name ?? '',
            $row->state_id,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
