<?php

namespace App\Exports;

use App\Models\ScrapSeller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScrapSellerExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ScrapSeller::orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'alies_id',
            'company_name',
            'business_age',
            'owner_name',
            'mobile',
            'owner_type',
            'address',
            'gst_no',
            'pan_no',
            'email',
            'owner_rent',
            'godownspace',
            'company_seller1',
            'company_seller2',
            'company_seller3',
            'company_seller4',
            'company_seller5',
            'tonmonth1',
            'tonmonth2',
            'tonmonth3',
            'tonmonth4',
            'tonmonth5',
            'total_ton',
            'other_business',
            'agni_business_value',
            'question1',
            'question2',
            'question3',
            'question4',
            'question5',
            'question6',
            'question7',
            'question8',
            'rep_id',
            'approval',
            'cdate',
            'created_at',
            'updated_at',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->alies_id,
            $row->company_name,
            $row->business_age,
            $row->owner_name,
            $row->mobile,
            $row->owner_type,
            $row->address,
            $row->gst_no,
            $row->pan_no,
            $row->email,
            $row->owner_rent,
            $row->godownspace,
            $row->company_seller1,
            $row->company_seller2,
            $row->company_seller3,
            $row->company_seller4,
            $row->company_seller5,
            $row->tonmonth1,
            $row->tonmonth2,
            $row->tonmonth3,
            $row->tonmonth4,
            $row->tonmonth5,
            $row->total_ton,
            $row->other_business,
            $row->agni_business_value,
            $row->question1,
            $row->question2,
            $row->question3,
            $row->question4,
            $row->question5,
            $row->question6,
            $row->question7,
            $row->question8,
            $row->rep_id,
            $row->approval,
            optional($row->cdate)?->format('Y-m-d'),
            optional($row->created_at)?->toDateTimeString(),
            optional($row->updated_at)?->toDateTimeString(),
        ];
    }
}
