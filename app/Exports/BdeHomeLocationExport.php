<?php

namespace App\Exports;

use App\Models\BdeHomeLocation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BdeHomeLocationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BdeHomeLocation::all();
    }

    public function headings(): array
    {
        return [

            'id',

            'bde_id',

            'home_lat',

            'home_long',

            'home_address',

            'created_at',

            'updated_at'

        ];
    }
}