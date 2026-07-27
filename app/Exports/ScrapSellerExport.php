<?php

namespace App\Exports;


use App\Models\ScrapSeller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ScrapSellerExport implements FromCollection, WithHeadings
{


    public function collection()
    {

        return ScrapSeller::all();

    }



    public function headings(): array
    {

        return [

            'id',
            'rep_id',
            'name',
            'customer_name',
            'mobile',
            'country_id',
            'state_id',
            'city_id',
            'pincode_id',
            'address',
            'gst_no',
            'pan_no',
            'email',
            'latitude',
            'longitude',
            'image',
            'dob',
            'date',
            'created_at',
            'updated_at'

        ];

    }


}