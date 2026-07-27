<?php

namespace App\Imports;

use App\Models\ScrapDistributor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScrapDistributorImport implements 
    ToModel,
    WithHeadingRow,
    WithValidation
{

    public function model(array $row)
    {

        return new ScrapDistributor([

            'name' => $row['name'],

            'mobile_number' => $row['mobile_number'],

            'email' => $row['email'],

            'address' => $row['address'],

            'status' => $row['status'] ?? 1,

        ]);

    }



    public function rules(): array
    {

        return [

            '*.name' => 'required|string',

            '*.mobile_number' => 'required',

            '*.email' => 'nullable|email',

            '*.address' => 'nullable|string',

        ];

    }

}