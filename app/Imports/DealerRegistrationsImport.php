<?php

namespace App\Imports;

use App\Models\DealerRegistration;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Column headings expected in the uploaded Excel/CSV file (case-insensitive,
 * spaces are converted to underscores by WithHeadingRow) must match the
 * actual dealer_registrations columns below -- these are the same names
 * used throughout the model, controller and export.
 */
class DealerRegistrationsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new DealerRegistration([
            'state_wise'       => $row['state_wise'] ?? null,
            'alias_id'         => $row['alias_id'] ?? null,
            'n_of_firm'        => $row['n_of_firm'] ?? null,
            'n_of_propriter'   => $row['n_of_propriter'] ?? null,
            'dealers_type'     => $row['dealers_type'] ?? null,
            'address'          => $row['address'] ?? null,
            'shop_est_yr'      => $row['shop_est_yr'] ?? null,
            'age_of_bus'       => $row['age_of_bus'] ?? null,
            'mobile_no'        => $row['mobile_no'] ?? null,
            'email'            => $row['email'] ?? null,
            'name_add_bank'    => $row['name_add_bank'] ?? null,
            'type_of_ac'       => $row['type_of_ac'] ?? null,
            'status_of_firm'   => $row['status_of_firm'] ?? null,
            'other_business'   => $row['other_business'] ?? null,
            'own_rent'         => $row['own_rent'] ?? null,
            'shop_areasq'      => $row['shop_areasq'] ?? null,
            'godown_areasq'    => $row['godown_areasq'] ?? null,

            'agni_exp_ton'          => $row['agni_exp_ton'] ?? null,
            'dealer_total_capacity' => $row['dealer_total_capacity'] ?? null,
            'so_approved_name'      => $row['so_approved_name'] ?? null,

            'shop_brand1' => $row['shop_brand1'] ?? null, 'shop_month_brand1' => $row['shop_month_brand1'] ?? null,
            'shop_brand2' => $row['shop_brand2'] ?? null, 'shop_month_brand2' => $row['shop_month_brand2'] ?? null,
            'shop_brand3' => $row['shop_brand3'] ?? null, 'shop_month_brand3' => $row['shop_month_brand3'] ?? null,
            'shop_brand4' => $row['shop_brand4'] ?? null, 'shop_month_brand4' => $row['shop_month_brand4'] ?? null,
            'shop_brand5' => $row['shop_brand5'] ?? null, 'shop_month_brand5' => $row['shop_month_brand5'] ?? null,
            'shop_brand6' => $row['shop_brand6'] ?? null, 'shop_month_brand6' => $row['shop_month_brand6'] ?? null,
            'commercial_brand' => $row['commercial_brand'] ?? null, 'commercial_ton' => $row['commercial_ton'] ?? null,

            'cement_brand1' => $row['cement_brand1'] ?? null, 'cement_month_cement1' => $row['cement_month_cement1'] ?? null,
            'cement_brand2' => $row['cement_brand2'] ?? null, 'cement_month_cement2' => $row['cement_month_cement2'] ?? null,
            'cement_brand3' => $row['cement_brand3'] ?? null, 'cement_month_cement3' => $row['cement_month_cement3'] ?? null,
            'cement_brand4' => $row['cement_brand4'] ?? null, 'cement_month_cement4' => $row['cement_month_cement4'] ?? null,

            'east'   => $row['east'] ?? null,   'sub_1' => $row['sub_1'] ?? null,   'e_dist' => $row['e_dist'] ?? null,   'other1' => $row['other1'] ?? null,
            'west'   => $row['west'] ?? null,   'sub_2' => $row['sub_2'] ?? null,   'w_dist' => $row['w_dist'] ?? null,   'other2' => $row['other2'] ?? null,
            'south'  => $row['south'] ?? null,  'sub_3' => $row['sub_3'] ?? null,   's_dist' => $row['s_dist'] ?? null,   'other3' => $row['other3'] ?? null,
            'north'  => $row['north'] ?? null,  'sub_4' => $row['sub_4'] ?? null,   'n_dist' => $row['n_dist'] ?? null,   'other4' => $row['other4'] ?? null,

            'admin_status' => 'Pending',
        ]);
    }

    public function rules(): array
    {
        $currentYear = (int) date('Y');

        return [
            'state_wise' => ['required', 'string', 'max:10'],
            'alias_id' => [
                'required',
                'string',
                'max:50',
                // Duplicate handling: an existing (non-trashed) alias_id
                // fails the row instead of silently overwriting a record.
                Rule::unique('dealer_registrations', 'alias_id'),
            ],
            'n_of_firm' => ['required', 'string', 'max:255'],
            'n_of_propriter' => ['required', 'string', 'max:255'],
            'dealers_type' => ['required', 'string', 'in:Main dealer,sub dealer,Nil'],
            'address' => ['required', 'string'],

            'shop_est_yr' => ['required', 'integer', 'min:1900', 'max:' . $currentYear],
            'age_of_bus' => ['nullable', 'numeric', 'min:0'],

            'mobile_no' => ['required', 'digits:10'],
            'email' => ['required', 'email'],

            'name_add_bank' => ['required', 'string', 'max:150'],
            'type_of_ac' => ['required', 'string'],
            'status_of_firm' => ['required', 'string'],
            'other_business' => ['nullable', 'string'],
            'own_rent' => ['required', 'string', 'in:own shop,rent shop'],

            'shop_areasq' => ['required', 'numeric', 'min:0'],
            'godown_areasq' => ['required', 'numeric', 'min:0'],

            'agni_exp_ton' => ['required', 'numeric', 'min:0'],
            'dealer_total_capacity' => ['required', 'numeric', 'min:0'],
            'so_approved_name' => ['required', 'string', 'max:100'],

            'sub_1' => ['nullable', 'in:Main dealer,sub dealer,Nil'],
            'sub_2' => ['nullable', 'in:Main dealer,sub dealer,Nil'],
            'sub_3' => ['nullable', 'in:Main dealer,sub dealer,Nil'],
            'sub_4' => ['nullable', 'in:Main dealer,sub dealer,Nil'],

            'e_dist' => ['nullable', 'numeric', 'min:0'],
            'w_dist' => ['nullable', 'numeric', 'min:0'],
            's_dist' => ['nullable', 'numeric', 'min:0'],
            'n_dist' => ['nullable', 'numeric', 'min:0'],

            'other1' => ['nullable', 'numeric', 'min:0'],
            'other2' => ['nullable', 'numeric', 'min:0'],
            'other3' => ['nullable', 'numeric', 'min:0'],
            'other4' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'alias_id.unique' => 'A dealer registration with this Alias ID already exists (duplicate row skipped).',
            'mobile_no.digits' => 'Mobile number must be exactly 10 digits.',
            'email.email' => 'A valid email address is required.',
            'dealers_type.in' => 'Dealer Type must be one of: Main dealer, sub dealer, Nil.',
        ];
    }
}
