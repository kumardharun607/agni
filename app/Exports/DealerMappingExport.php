<?php

namespace App\Exports;

use App\Models\DealerMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DealerMappingExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DealerMapping::with(['dealer', 'bde'])->get();
    }

    public function headings(): array
    {
        return ['Dealer Alias ID', 'Dealer Name', 'BDE Emp Code', 'BDE Name'];
    }

    public function map($m): array
    {
        return [
            $m->dealer->alias_id ?? '',
            $m->dealer->name ?? '',
            $m->bde->emp_code ?? '',
            $m->bde->name ?? '',
        ];
    }
}
