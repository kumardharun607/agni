<?php

namespace App\Imports;

use App\Models\ScrapDistributor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Validation\ValidationException;

class ScrapDistributorImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    WithEvents
{
    use SkipsFailures;

    /**
     * Expected column headings (after WithHeadingRow formatting: lowercase, spaces → underscores).
     */
    public static array $expectedHeadings = [
        'rep_id',
        'name',
        'customer_name',
        'mobile',
        'country_id',
        'state_id',
        'city_id',
        'pincode_id',
        'address',
        'gst_no',
        'pan_no',
        'email',
        'latitude',
        'longitude',
        'dob',
        'date',
    ];

    public function model(array $row)
    {
        return new ScrapDistributor([
            'rep_id'         => $row['rep_id'] ?? null,
            'name'           => $row['name'] ?? null,
            'customer_name'  => $row['customer_name'] ?? null,
            'mobile'         => $row['mobile'] ?? null,
            'country_id'     => $row['country_id'] ?? null,
            'state_id'       => $row['state_id'] ?? null,
            'city_id'        => $row['city_id'] ?? null,
            'pincode_id'     => $row['pincode_id'] ?? null,
            'address'        => $row['address'] ?? null,
            'gst_no'         => $row['gst_no'] ?? null,
            'pan_no'         => $row['pan_no'] ?? null,
            'email'          => $row['email'] ?? null,
            'latitude'       => $row['latitude'] ?? null,
            'longitude'      => $row['longitude'] ?? null,
            'dob'            => $row['dob'] ?? null,
            'date'           => $row['date'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name'   => 'required|string',
            '*.mobile' => 'required',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->reader->getActiveSheet();
                $highestColumn = $sheet->getHighestColumn();
                $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0] ?? [];

                // Normalize the same way WithHeadingRow does
                $actual = [];
                foreach ($headerRow as $heading) {
                    if ($heading === null || $heading === '') {
                        continue;
                    }
                    $actual[] = strtolower(str_replace(' ', '_', trim((string) $heading)));
                }

                $missing = array_diff(self::$expectedHeadings, $actual);

                // Allow optional columns to be missing; only require core ones for mismatch check
                $required = ['name', 'mobile'];
                $missingRequired = array_intersect($missing, $required);

                // If almost nothing matches, treat as full column mismatch
                $matched = array_intersect(self::$expectedHeadings, $actual);
                if (count($matched) < 2 || ! empty($missingRequired)) {
                    throw ValidationException::withMessages([
                        'file' => 'Column mismatch. Expected columns include: ' . implode(', ', self::$expectedHeadings) .
                            '. Found: ' . (empty($actual) ? '(none)' : implode(', ', $actual)) . '.',
                    ]);
                }
            },
        ];
    }
}
