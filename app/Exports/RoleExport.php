<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RoleExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Role::orderBy('level')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Level'];
    }

    public function map($r): array
    {
        return [$r->id, $r->name, $r->level];
    }
}
