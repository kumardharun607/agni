<?php

namespace App\Exports;

use App\Http\Controllers\DealerRegistration\DealerRegistrationController as DealerRegistrationDealerRegistrationController;
use App\Models\DealerRegistration;
use App\Http\Controllers\DealerRegistrationController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DealerRegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DealerRegistration::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Alias ID', 'Apply ID', 'State', 'Serial No', 'Apply No',
            'Shop Est. Year', 'Age of Business', 'Own/Rent', 'Agni Expected Ton',
            'Dealer Total Capacity', 'Nearby Dealers Info', 'Sales Officer',
            'Manager Name', 'Manager Status', 'Admin Status',
            'Firm Name', 'Proprietor Name', 'Address', 'Email', 'Mobile No',
            'Alt Mobile 1', 'Alt Mobile 2', 'Bank Name', 'A/C Type', 'Firm Status',
            'Other Business', 'Turnover/Month', 'Turnover/Year',
            'East', 'East Type', 'East Dist', 'West', 'West Type', 'West Dist', 'South', 'South Type', 'South Dist', 'North', 'North Type', 'North Dist',
            'Steel Brand 1', 'Ton/Month 1', 'Steel Brand 2', 'Ton/Month 2',
            'Steel Brand 3', 'Ton/Month 3', 'Steel Brand 4', 'Ton/Month 4',
            'Steel Brand 5', 'Ton/Month 5', 'Steel Brand 6', 'Ton/Month 6',
            'Commercial Brand', 'Commercial Ton',
            'Cement Brand 1', 'Ton/Month 1', 'Cement Brand 2', 'Ton/Month 2',
            'Cement Brand 3', 'Ton/Month 3', 'Cement Brand 4', 'Ton/Month 4',
            'East Ton/Month', 'West Ton/Month', 'South Ton/Month', 'North Ton/Month', 'Dealer Type',
            'Shop Area (sq.ft)', 'Godown Area (sq.ft)', 'Created At',
        ];
    }

    public function map($dealer): array
    {
        $states = DealerRegistrationDealerRegistrationController::states();

        return [
            $dealer->id, $dealer->alias_id, $dealer->apply_id,
            $states[$dealer->state_wise] ?? $dealer->state_wise,
            $dealer->serial_no, $dealer->apply_no,
            $dealer->shop_est_yr, $dealer->age_of_bus, $dealer->own_rent, $dealer->agni_exp_ton,
            $dealer->dealer_total_capacity, $dealer->near_d, $dealer->so_approved_name,
            $dealer->manager_name, $dealer->manager_status, $dealer->admin_status,
            $dealer->n_of_firm, $dealer->n_of_propriter, $dealer->address, $dealer->email, $dealer->mobile_no,
            $dealer->alter_mobno1, $dealer->alter_mobno2, $dealer->name_add_bank, $dealer->type_of_ac, $dealer->status_of_firm,
            $dealer->other_business, $dealer->total_turnover_month, $dealer->total_turnover_year,
            $dealer->east, $dealer->sub_1, $dealer->e_dist, $dealer->west, $dealer->sub_2, $dealer->w_dist,
            $dealer->south, $dealer->sub_3, $dealer->s_dist, $dealer->north, $dealer->sub_4, $dealer->n_dist,
            $dealer->shop_brand1, $dealer->shop_month_brand1, $dealer->shop_brand2, $dealer->shop_month_brand2,
            $dealer->shop_brand3, $dealer->shop_month_brand3, $dealer->shop_brand4, $dealer->shop_month_brand4,
            $dealer->shop_brand5, $dealer->shop_month_brand5, $dealer->shop_brand6, $dealer->shop_month_brand6,
            $dealer->commercial_brand, $dealer->commercial_ton,
            $dealer->cement_brand1, $dealer->cement_month_cement1, $dealer->cement_brand2, $dealer->cement_month_cement2,
            $dealer->cement_brand3, $dealer->cement_month_cement3, $dealer->cement_brand4, $dealer->cement_month_cement4,
            $dealer->other1, $dealer->other2, $dealer->other3, $dealer->other4, $dealer->dealers_type,
            $dealer->shop_areasq, $dealer->godown_areasq,
            $dealer->created_at?->format('d-m-Y h:i A'),
        ];
    }
}
