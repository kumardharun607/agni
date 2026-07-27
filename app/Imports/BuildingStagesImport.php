<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\BuildingStage;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BuildingStagesImport implements
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

        return new BuildingStage([
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
                Rule::unique('building_stage', 'name'),
            ],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'Building stage name is required.',
            'name.string' => 'Building stage name must contain valid text.',
            'name.unique' => 'This name already exists (duplicate row skipped).',
            'name.max' => 'Building stage name may not exceed 255 characters.',
        ];
    }
}