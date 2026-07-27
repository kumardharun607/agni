<?php

namespace App\Exports;

use App\Models\PermissionDropdown;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermissionDropdownExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PermissionDropdown::orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name'];
    }

    public function map($p): array
    {
        return [$p->id, $p->name];
    }
}
