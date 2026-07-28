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
        // Include soft-deleted so export reflects full table contents
        return User::withTrashed()->with('role')->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Emp Code',
            'Role ID',
            'Role',
            'Name',
            'Mobile',
            'Country ID',
            'State ID',
            'City ID',
            'Pincode ID',
            'Address',
            'DOJ',
            'DOB',
            'Email',
            'Plain Password',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }

    public function map($u): array
    {
        return [
            $u->id,
            $u->emp_code,
            $u->role_id,
            $u->role->name ?? '',
            $u->name,
            $u->mobile,
            $u->country_id,
            $u->state_id,
            $u->city_id,
            $u->pincode_id,
            $u->address,
            optional($u->doj)->format('Y-m-d'),
            optional($u->dob)->format('Y-m-d'),
            $u->email,
            $u->plain_password,
            optional($u->created_at)->format('Y-m-d H:i:s'),
            optional($u->updated_at)->format('Y-m-d H:i:s'),
            optional($u->deleted_at)->format('Y-m-d H:i:s'),
        ];
    }
}
