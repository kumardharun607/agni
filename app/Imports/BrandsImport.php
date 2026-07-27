<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BrandsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $name = trim((string) ($row['name'] ?? ''));

        if ($name === '') {
            return null;
        }

        return new Brand([
            'name' => $name,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name'),
            ],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'Brand name is required.',
            'name.string' => 'Brand name must contain valid text.',
            'name.unique' => 'This name already exists (duplicate row skipped).',
            'name.max' => 'Brand name may not exceed 255 characters.',
        ];
    }
}