<?php

namespace App\Exports;

use App\Models\BuildingStage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuildingStagesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return BuildingStage::orderBy('id')->get();
    }

    public function headings(): array
    {
        return ['id', 'name', 'created_at', 'updated_at'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            optional($row->created_at)?->toDateTimeString(),
            optional($row->updated_at)?->toDateTimeString(),
        ];
    }
}
