<?php

namespace App\Http\Requests\ScrapSeller;

use Illuminate\Foundation\Http\FormRequest;

class StoreScrapSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alies_id' => ['nullable', 'string', 'max:50'],
            'company_name' => ['required', 'string', 'max:255'],
            'business_age' => ['nullable', 'string', 'max:50'],
            'owner_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:scrap_sellers,mobile'],
            'owner_type' => ['nullable', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'gst_no' => ['nullable', 'string', 'max:30'],
            'pan_no' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:scrap_sellers,email'],
            'owner_rent' => ['nullable', 'string', 'max:100'],
            'godownspace' => ['nullable', 'string', 'max:100'],
            'company_seller1' => ['nullable', 'string', 'max:255'],
            'company_seller2' => ['nullable', 'string', 'max:255'],
            'company_seller3' => ['nullable', 'string', 'max:255'],
            'company_seller4' => ['nullable', 'string', 'max:255'],
            'company_seller5' => ['nullable', 'string', 'max:255'],
            'tonmonth1' => ['nullable', 'string', 'max:50'],
            'tonmonth2' => ['nullable', 'string', 'max:50'],
            'tonmonth3' => ['nullable', 'string', 'max:50'],
            'tonmonth4' => ['nullable', 'string', 'max:50'],
            'tonmonth5' => ['nullable', 'string', 'max:50'],
            'total_ton' => ['nullable', 'string', 'max:50'],
            'other_business' => ['nullable', 'string', 'max:255'],
            'agni_business_value' => ['nullable', 'string', 'max:255'],
            'question1' => ['nullable', 'string'],
            'question2' => ['nullable', 'string'],
            'question3' => ['nullable', 'string'],
            'question4' => ['nullable', 'string'],
            'question5' => ['nullable', 'string'],
            'question6' => ['nullable', 'string'],
            'question7' => ['nullable', 'string'],
            'question8' => ['nullable', 'string'],
            'shop_image' => ['nullable', 'image', 'max:4096'],
            'godown_image' => ['nullable', 'image', 'max:4096'],
            'pancard_image' => ['nullable', 'image', 'max:4096'],
            'aadhar_front_image' => ['nullable', 'image', 'max:4096'],
            'aadhar_back_image' => ['nullable', 'image', 'max:4096'],
            'reg_certificate_image' => ['nullable', 'image', 'max:4096'],
            'action' => ['nullable', 'string', 'max:50'],
            'cdate' => ['nullable', 'date'],
            'rep_id' => ['nullable', 'string', 'max:50'],
            'approval' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required.',
            'owner_name.required' => 'Owner name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number must contain only digits (10–15 digits).',
            'mobile.unique' => 'This mobile number is already registered.',
            'address.required' => 'Address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
