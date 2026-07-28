<?php

namespace App\Imports;

use App\Models\BdeHomeLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Validation\ValidationException;

class BdeHomeLocationImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    WithEvents
{
    use SkipsFailures;

    public static array $expectedHeadings = [
        'bde_id',
        'home_lat',
        'home_long',
        'home_address',
    ];

    public function model(array $row)
    {
        return new BdeHomeLocation([
            'bde_id'       => $row['bde_id'] ?? null,
            'home_lat'     => $row['home_lat'] ?? null,
            'home_long'    => $row['home_long'] ?? null,
            'home_address' => $row['home_address'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.bde_id'       => 'required',
            '*.home_lat'     => 'required',
            '*.home_long'    => 'required',
            '*.home_address' => 'required|string',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->reader->getActiveSheet();
                $highestColumn = $sheet->getHighestColumn();
                $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0] ?? [];

                $actual = [];
                foreach ($headerRow as $heading) {
                    if ($heading === null || $heading === '') {
                        continue;
                    }
                    $actual[] = strtolower(str_replace(' ', '_', trim((string) $heading)));
                }

                $missing = array_diff(self::$expectedHeadings, $actual);
                $matched = array_intersect(self::$expectedHeadings, $actual);

                if (count($matched) < 2 || ! empty($missing)) {
                    throw ValidationException::withMessages([
                        'file' => 'Column mismatch. Expected columns: ' . implode(', ', self::$expectedHeadings) .
                            '. Found: ' . (empty($actual) ? '(none)' : implode(', ', $actual)) . '.',
                    ]);
                }
            },
        ];
    }
}
