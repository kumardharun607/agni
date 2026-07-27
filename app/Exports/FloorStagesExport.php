<?php

namespace App\Exports;

use App\Models\FloorStage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FloorStagesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return FloorStage::query()
            ->select([
                'id',
                'name',
                'created_at',
                'updated_at',
            ])
            ->latest('id');
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Floor Stage Name',
            'Created At',
            'Updated At',
        ];
    }

    public function map($floorStage): array
    {
        static $serialNumber = 0;

        $serialNumber++;

        return [
            $serialNumber,
            $floorStage->name,
            $floorStage->created_at
                ? $floorStage->created_at->format('d-m-Y h:i A')
                : '-',
            $floorStage->updated_at
                ? $floorStage->updated_at->format('d-m-Y h:i A')
                : '-',
        ];
    }
}