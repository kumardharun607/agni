<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::with('role')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['Emp Code', 'Name', 'Role', 'Mobile', 'Email'];
    }

    public function map($u): array
    {
        return [
            $u->emp_code,
            $u->name,
            $u->role->name ?? '',
            $u->mobile,
            $u->email,
        ];
    }
}
