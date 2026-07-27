<?php

namespace App\Exports;

use App\Models\Dealer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DealerExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Dealer::with(['country', 'state', 'city', 'pincode'])->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Alias ID', 'Name', 'Type', 'Contact Person', 'Mobile', 'Email',
            'GST No', 'PAN No', 'Country', 'State', 'City', 'Pincode', 'Address',
        ];
    }

    public function map($d): array
    {
        return [
            $d->alias_id,
            $d->name,
            method_exists($d, 'typeLabel') ? $d->typeLabel() : $d->client_type,
            $d->contact_person,
            $d->mobile,
            $d->email,
            $d->gst_no,
            $d->pan_no,
            $d->country->name ?? '',
            $d->state->name ?? '',
            $d->city->name ?? '',
            $d->pincode->pincode ?? '',
            $d->address,
        ];
    }
}
