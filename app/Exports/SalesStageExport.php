<?php

namespace App\Exports;

use App\Models\SalesStage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesStageExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return SalesStage::orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name'];
    }

    public function map($s): array
    {
        return [$s->id, $s->name];
    }
}
