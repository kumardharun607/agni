<?php

namespace App\Exports;

use App\Models\ScrapDistributor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScrapDistributorExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ScrapDistributor::orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'id', 'rep_id', 'name', 'customer_name', 'mobile',
            'country_id', 'state_id', 'city_id', 'pincode_id',
            'address', 'gst_no', 'pan_no', 'email',
            'latitude', 'longitude', 'dob', 'date',
            'created_at', 'updated_at',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id, $row->rep_id, $row->name, $row->customer_name, $row->mobile,
            $row->country_id, $row->state_id, $row->city_id, $row->pincode_id,
            $row->address, $row->gst_no, $row->pan_no, $row->email,
            $row->latitude, $row->longitude, $row->dob, $row->date,
            optional($row->created_at)?->toDateTimeString(),
            optional($row->updated_at)?->toDateTimeString(),
        ];
    }
}
