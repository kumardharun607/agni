<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountryExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Country::orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Code', 'Created At', 'Updated At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->code,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
