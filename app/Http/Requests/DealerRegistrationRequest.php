<?php

namespace App\Http\Requests;

use App\Http\Controllers\DealerRegistration\DealerRegistrationController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DealerRegistrationRequest extends FormRequest
{
    /**
     * Permission is enforced in the controller (abort_unless) before this
     * request is even resolved for store()/update(), so this just makes
     * sure an authenticated user is present.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Shared server-side validation rules for both create and update.
     * Image fields are required only when creating a brand new record.
     */
    public function rules(): array
    {
        $isCreate = $this->routeIs('dealer-registrations.store');
        $currentYear = (int) date('Y');

        return [
            // -----------------------------------------------------------
            // Basic information
            // -----------------------------------------------------------
            'state_wise' => ['required', 'string', 'max:10', 'in:' . implode(',', array_keys(DealerRegistrationController::states()))],
            'n_of_firm' => ['required', 'string', 'max:255'],
            'alias_id' => ['required', 'string', 'max:50'],
            'n_of_propriter' => ['required', 'string', 'max:255'],
            'dealers_type' => ['required', 'string', 'in:' . implode(',', DealerRegistrationController::dealerTypes())],
            'address' => ['required', 'string'],
            'shop_est_yr' => ['required', 'integer', 'min:1900', 'max:' . $currentYear],
            'age_of_bus' => ['nullable', 'numeric', 'min:0'],
            'mobile_no' => ['required', 'digits:10'],
            'alter_mobno1' => ['nullable', 'digits:10'],
            'alter_mobno2' => ['nullable', 'digits:10'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'name_add_bank' => ['required', 'string', 'max:150'],
            'own_rent' => ['required', 'string', 'in:' . implode(',', array_keys(DealerRegistrationController::ownRentOptions()))],
            'shop_areasq' => ['required', 'numeric', 'min:0'],
            'godown_areasq' => ['required', 'numeric', 'min:0'],

            // -----------------------------------------------------------
            // Checkbox groups -> validated as arrays, stored as CSV
            // -----------------------------------------------------------
            'type_of_ac' => ['required', 'array', 'min:1'],
            'type_of_ac.*' => ['string', 'in:' . implode(',', DealerRegistrationController::accountTypes())],

            'status_of_firm' => ['required', 'array', 'min:1'],
            'status_of_firm.*' => ['string', 'in:' . implode(',', DealerRegistrationController::firmStatuses())],

            'other_business' => ['nullable', 'array'],
            'other_business.*' => ['string', 'in:' . implode(',', DealerRegistrationController::otherBusinessOptions())],

            // -----------------------------------------------------------
            // Images
            // -----------------------------------------------------------
            'photo_upload1' => [$isCreate ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photo_upload2' => [$isCreate ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            // -----------------------------------------------------------
            // Steel brands (1-6) + tonnage
            // -----------------------------------------------------------
            'shop_brand1' => ['nullable', 'string', 'max:100'], 'shop_month_brand1' => ['nullable', 'numeric', 'min:0'],
            'shop_brand2' => ['nullable', 'string', 'max:100'], 'shop_month_brand2' => ['nullable', 'numeric', 'min:0'],
            'shop_brand3' => ['nullable', 'string', 'max:100'], 'shop_month_brand3' => ['nullable', 'numeric', 'min:0'],
            'shop_brand4' => ['nullable', 'string', 'max:100'], 'shop_month_brand4' => ['nullable', 'numeric', 'min:0'],
            'shop_brand5' => ['nullable', 'string', 'max:100'], 'shop_month_brand5' => ['nullable', 'numeric', 'min:0'],
            'shop_brand6' => ['nullable', 'string', 'max:100'], 'shop_month_brand6' => ['nullable', 'numeric', 'min:0'],
            'commercial_brand' => ['nullable', 'string', 'max:100'],
            'commercial_ton' => ['nullable', 'numeric', 'min:0'],

            // -----------------------------------------------------------
            // Cement brands (1-4) + tonnage
            // -----------------------------------------------------------
            'cement_brand1' => ['nullable', 'string', 'max:100'], 'cement_month_cement1' => ['nullable', 'numeric', 'min:0'],
            'cement_brand2' => ['nullable', 'string', 'max:100'], 'cement_month_cement2' => ['nullable', 'numeric', 'min:0'],
            'cement_brand3' => ['nullable', 'string', 'max:100'], 'cement_month_cement3' => ['nullable', 'numeric', 'min:0'],
            'cement_brand4' => ['nullable', 'string', 'max:100'], 'cement_month_cement4' => ['nullable', 'numeric', 'min:0'],

            // -----------------------------------------------------------
            // Capacity / turnover
            // -----------------------------------------------------------
            'agni_exp_ton' => ['required', 'numeric', 'min:0'],
            'dealer_total_capacity' => ['required', 'numeric', 'min:0'],
            'total_turnover_month' => ['nullable', 'numeric', 'min:0'],
            'total_turnover_year' => ['nullable', 'numeric', 'min:0'],
            'near_d' => ['nullable', 'string'],

            // -----------------------------------------------------------
            // Nearby Agni Dealers - one card, 4 directions
            // Dealer Name / Dealer Type / KMS / TON-MONTH
            // -----------------------------------------------------------
            'east' => ['nullable', 'string', 'max:150'], 'e_dist' => ['nullable', 'numeric', 'min:0'], 'sub_1' => ['nullable', 'string', 'in:' . implode(',', DealerRegistrationController::dealerTypes())], 'other1' => ['nullable', 'numeric', 'min:0'],
            'west' => ['nullable', 'string', 'max:150'], 'w_dist' => ['nullable', 'numeric', 'min:0'], 'sub_2' => ['nullable', 'string', 'in:' . implode(',', DealerRegistrationController::dealerTypes())], 'other2' => ['nullable', 'numeric', 'min:0'],
            'south' => ['nullable', 'string', 'max:150'], 's_dist' => ['nullable', 'numeric', 'min:0'], 'sub_3' => ['nullable', 'string', 'in:' . implode(',', DealerRegistrationController::dealerTypes())], 'other3' => ['nullable', 'numeric', 'min:0'],
            'north' => ['nullable', 'string', 'max:150'], 'n_dist' => ['nullable', 'numeric', 'min:0'], 'sub_4' => ['nullable', 'string', 'in:' . implode(',', DealerRegistrationController::dealerTypes())], 'other4' => ['nullable', 'numeric', 'min:0'],

            // -----------------------------------------------------------
            // Sales Officer / Sr. Marketing Manager
            // -----------------------------------------------------------
            'so_approved_name' => ['required', 'string', 'max:100'],
            'manager_name' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'mobile_no.digits' => 'Mobile number must be exactly 10 digits.',
            'alter_mobno1.digits' => 'Alternate mobile number must be exactly 10 digits.',
            'alter_mobno2.digits' => 'Alternate mobile number must be exactly 10 digits.',
            'email.email' => 'Please enter a valid email address.',
            'type_of_ac.required' => 'Please select at least one account type.',
            'status_of_firm.required' => 'Please select at least one firm status.',
            'photo_upload1.required' => 'Shop image is required.',
            'photo_upload2.required' => 'Godown image is required.',
            'shop_est_yr.max' => 'Shop established year cannot be in the future.',
        ];
    }

    /**
     * Attribute names exactly matching the excluded/visible field set from
     * the spec, used only to make validation-error text friendlier.
     */
    public function attributes(): array
    {
        return [
            'n_of_firm' => 'shop name',
            'n_of_propriter' => 'owner name',
            'name_add_bank' => 'name of the bank',
            'shop_areasq' => 'shop area',
            'godown_areasq' => 'godown area',
            'agni_exp_ton' => 'Agni expected tonnage',
            'so_approved_name' => 'Sales Officer name',
            'photo_upload1' => 'shop image',
            'photo_upload2' => 'godown image',
        ];
    }
}
