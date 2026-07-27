<?php

namespace App\Exports;

use App\Models\BuildingStage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuildingStagesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return BuildingStage::query()
            ->select([
                'id',
                'name',
                'created_at',
            ])
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Building Stage Name',
            'Created At',
        ];
    }

    public function map($buildingStage): array
    {
        return [
            $buildingStage->id,
            $buildingStage->name,
            $buildingStage->created_at
                ? $buildingStage->created_at->format('d-m-Y h:i A')
                : '-',
        ];
    }
}