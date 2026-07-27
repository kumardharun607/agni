<?php

namespace App\Http\Requests\Pincode;

use Illuminate\Foundation\Http\FormRequest;

class PincodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city_id' => ['required', 'exists:cities,id'],
            'pincode' => ['required', 'string', 'max:10'],
        ];
    }
}
