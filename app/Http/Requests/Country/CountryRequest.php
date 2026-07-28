<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryId = $this->route('country')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('countries', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($countryId),
            ],
            'code' => ['nullable', 'string', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'This country already exists.',
            'name.required' => 'Country name is required.',
        ];
    }
}
