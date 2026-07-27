<?php

namespace App\Exports;

use App\Models\SoHomeLocation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SoHomeLocationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SoHomeLocation::all();
    }

    public function headings(): array
    {
        return [

            'id',

            'so_id',

            'home_lat',

            'home_long',

            'home_address',

            'created_at',

            'updated_at'

        ];
    }
}