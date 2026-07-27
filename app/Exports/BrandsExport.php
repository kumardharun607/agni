<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Export only active brands.
     *
     * Soft deleted brands are automatically excluded
     * by the Brand model's SoftDeletes trait.
     */
    public function query()
    {
        return Brand::query()
            ->select([
                'id',
                'name',
                'created_at',
                'updated_at',
            ])
            ->latest('id');
    }

    /**
     * Excel column headings.
     */
    public function headings(): array
    {
        return [
            'S.No',
            'Brand Name',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map database records to Excel rows.
     */
    public function map($brand): array
    {
        static $serialNumber = 0;

        $serialNumber++;

        return [
            $serialNumber,
            $brand->name,
            $brand->created_at
                ? $brand->created_at->format('d-m-Y h:i A')
                : '-',
            $brand->updated_at
                ? $brand->updated_at->format('d-m-Y h:i A')
                : '-',
        ];
    }
}