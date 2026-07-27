<?php

namespace App\Exports;

use App\Models\State;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StateExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return State::with('country')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Country', 'Country ID', 'Created At', 'Updated At'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->country->name ?? '',
            $row->country_id,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
