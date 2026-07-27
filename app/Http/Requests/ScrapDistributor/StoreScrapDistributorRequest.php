<?php

namespace App\Http\Requests\ScrapDistributor;

use Illuminate\Foundation\Http\FormRequest;

class StoreScrapDistributorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rep_id' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'customer_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:scrap_distributors,mobile'],
            'country_id' => ['required', 'exists:countries,id'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'pincode_id' => ['required', 'exists:pincodes,id'],
            'address' => ['required', 'string'],
            'gst_no' => ['nullable', 'string', 'max:30'],
            'pan_no' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:scrap_distributors,email'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'max:2048'],
            'dob' => ['nullable', 'date'],
            'date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Distributor name is required.',
            'customer_name.required' => 'Customer name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number must contain only digits (10–15 digits).',
            'mobile.unique' => 'This mobile number is already registered.',
            'country_id.required' => 'Please select a country.',
            'country_id.exists' => 'Selected country is invalid.',
            'state_id.required' => 'Please select a state.',
            'state_id.exists' => 'Selected state is invalid.',
            'city_id.required' => 'Please select a city.',
            'city_id.exists' => 'Selected city is invalid.',
            'pincode_id.required' => 'Please select a pincode.',
            'pincode_id.exists' => 'Selected pincode is invalid.',
            'address.required' => 'Address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'latitude.numeric' => 'Latitude must be a number.',
            'latitude.between' => 'Latitude must be between -90 and 90.',
            'longitude.numeric' => 'Longitude must be a number.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
            'dob.date' => 'DOB must be a valid date.',
            'date.date' => 'Date must be a valid date.',
        ];
    }
}
