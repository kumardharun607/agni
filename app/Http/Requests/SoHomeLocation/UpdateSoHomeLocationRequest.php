<?php

namespace App\Http\Requests\SoHomeLocation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSoHomeLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'so_id' => 'required|string|max:100',

            'home_lat' => 'required|numeric|between:-90,90',

            'home_long' => 'required|numeric|between:-180,180',

            'home_address' => 'required|string',

        ];
    }
}
