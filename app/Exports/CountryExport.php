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
        return Country::orderBy('id')->get();
    }

    public function headings(): array
    {
        return ['id', 'name', 'code', 'created_at', 'updated_at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->code,
            optional($row->created_at)?->toDateTimeString(),
            optional($row->updated_at)?->toDateTimeString(),
        ];
    }
}
