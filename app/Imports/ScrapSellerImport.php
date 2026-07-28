<?php

namespace App\Imports;

use App\Models\ScrapSeller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
<<<<<<< HEAD
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Validation\ValidationException;

class ScrapSellerImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    WithEvents
{
    use SkipsFailures;

    /**
     * Expected column headings (after WithHeadingRow formatting).
     * Image columns are not imported via Excel.
     */
    public static array $expectedHeadings = [
        'alies_id',
        'company_name',
        'business_age',
        'owner_name',
        'mobile',
        'owner_type',
        'address',
        'gst_no',
        'pan_no',
        'email',
        'owner_rent',
        'godownspace',
        'company_seller1',
        'company_seller2',
        'company_seller3',
        'company_seller4',
        'company_seller5',
        'tonmonth1',
        'tonmonth2',
        'tonmonth3',
        'tonmonth4',
        'tonmonth5',
        'total_ton',
        'other_business',
        'agni_business_value',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'question6',
        'question7',
        'question8',
        'action',
        'cdate',
        'rep_id',
        'approval',
    ];

    public function model(array $row)
    {
        return new ScrapSeller([
            'alies_id'            => $row['alies_id'] ?? null,
            'company_name'        => $row['company_name'] ?? null,
            'business_age'        => $row['business_age'] ?? null,
            'owner_name'          => $row['owner_name'] ?? null,
            'mobile'              => $row['mobile'] ?? null,
            'owner_type'          => $row['owner_type'] ?? null,
            'address'             => $row['address'] ?? null,
            'gst_no'              => $row['gst_no'] ?? null,
            'pan_no'              => $row['pan_no'] ?? null,
            'email'               => $row['email'] ?? null,
            'owner_rent'          => $row['owner_rent'] ?? null,
            'godownspace'         => $row['godownspace'] ?? null,
            'company_seller1'     => $row['company_seller1'] ?? null,
            'company_seller2'     => $row['company_seller2'] ?? null,
            'company_seller3'     => $row['company_seller3'] ?? null,
            'company_seller4'     => $row['company_seller4'] ?? null,
            'company_seller5'     => $row['company_seller5'] ?? null,
            'tonmonth1'           => $row['tonmonth1'] ?? null,
            'tonmonth2'           => $row['tonmonth2'] ?? null,
            'tonmonth3'           => $row['tonmonth3'] ?? null,
            'tonmonth4'           => $row['tonmonth4'] ?? null,
            'tonmonth5'           => $row['tonmonth5'] ?? null,
            'total_ton'           => $row['total_ton'] ?? null,
            'other_business'      => $row['other_business'] ?? null,
            'agni_business_value' => $row['agni_business_value'] ?? null,
            'question1'           => $row['question1'] ?? null,
            'question2'           => $row['question2'] ?? null,
            'question3'           => $row['question3'] ?? null,
            'question4'           => $row['question4'] ?? null,
            'question5'           => $row['question5'] ?? null,
            'question6'           => $row['question6'] ?? null,
            'question7'           => $row['question7'] ?? null,
            'question8'           => $row['question8'] ?? null,
            'action'              => $row['action'] ?? null,
            'cdate'               => $row['cdate'] ?? null,
            'rep_id'              => $row['rep_id'] ?? null,
            'approval'            => $row['approval'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.company_name' => 'required|string',
            '*.owner_name'   => 'required|string',
            '*.mobile'       => 'required',
            '*.address'      => 'required|string',
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

                $required = ['company_name', 'owner_name', 'mobile', 'address'];
                $missingRequired = array_diff($required, $actual);
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
=======
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ScrapSellerImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $company = $row['company_name'] ?? $row['company name'] ?? null;
        if (! $company) {
            return null;
        }

        return new ScrapSeller([
            'alies_id' => $row['alies_id'] ?? null,
            'company_name' => $company,
            'business_age' => $row['business_age'] ?? null,
            'owner_name' => $row['owner_name'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'owner_type' => $row['owner_type'] ?? null,
            'address' => $row['address'] ?? null,
            'gst_no' => $row['gst_no'] ?? null,
            'pan_no' => $row['pan_no'] ?? null,
            'email' => $row['email'] ?? null,
            'owner_rent' => $row['owner_rent'] ?? null,
            'godownspace' => $row['godownspace'] ?? null,
            'company_seller1' => $row['company_seller1'] ?? null,
            'company_seller2' => $row['company_seller2'] ?? null,
            'company_seller3' => $row['company_seller3'] ?? null,
            'company_seller4' => $row['company_seller4'] ?? null,
            'company_seller5' => $row['company_seller5'] ?? null,
            'tonmonth1' => $row['tonmonth1'] ?? null,
            'tonmonth2' => $row['tonmonth2'] ?? null,
            'tonmonth3' => $row['tonmonth3'] ?? null,
            'tonmonth4' => $row['tonmonth4'] ?? null,
            'tonmonth5' => $row['tonmonth5'] ?? null,
            'total_ton' => $row['total_ton'] ?? null,
            'other_business' => $row['other_business'] ?? null,
            'agni_business_value' => $row['agni_business_value'] ?? null,
            'rep_id' => $row['rep_id'] ?? null,
            'approval' => $row['approval'] ?? null,
        ]);
    }
>>>>>>> b1d09de9960bbbdde66a81dfd9cc085dec352046
}
