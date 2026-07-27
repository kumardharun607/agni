<?php

namespace App\Imports;

use App\Models\ScrapSeller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ScrapSellerImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $company = $row['company_name'] ?? $row['company name'] ?? null;
        if (! $company) {
            return null;
        }

        return new ScrapSeller([
            'alies_id' => $row['alies_id'] ?? null,
            'company_name' => $company,
            'business_age' => $row['business_age'] ?? null,
            'owner_name' => $row['owner_name'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'owner_type' => $row['owner_type'] ?? null,
            'address' => $row['address'] ?? null,
            'gst_no' => $row['gst_no'] ?? null,
            'pan_no' => $row['pan_no'] ?? null,
            'email' => $row['email'] ?? null,
            'owner_rent' => $row['owner_rent'] ?? null,
            'godownspace' => $row['godownspace'] ?? null,
            'company_seller1' => $row['company_seller1'] ?? null,
            'company_seller2' => $row['company_seller2'] ?? null,
            'company_seller3' => $row['company_seller3'] ?? null,
            'company_seller4' => $row['company_seller4'] ?? null,
            'company_seller5' => $row['company_seller5'] ?? null,
            'tonmonth1' => $row['tonmonth1'] ?? null,
            'tonmonth2' => $row['tonmonth2'] ?? null,
            'tonmonth3' => $row['tonmonth3'] ?? null,
            'tonmonth4' => $row['tonmonth4'] ?? null,
            'tonmonth5' => $row['tonmonth5'] ?? null,
            'total_ton' => $row['total_ton'] ?? null,
            'other_business' => $row['other_business'] ?? null,
            'agni_business_value' => $row['agni_business_value'] ?? null,
            'rep_id' => $row['rep_id'] ?? null,
            'approval' => $row['approval'] ?? null,
        ]);
    }
}
