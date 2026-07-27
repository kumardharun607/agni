<?php

namespace App\Repositories;

use App\Models\SoHomeLocation;

class SoHomeLocationRepository
{
    public function all()
    {
        return SoHomeLocation::with([
            'country',
            'state',
            'city',
            'pincode'
        ])
        ->latest()
        ->paginate(10);
    }

    public function store(array $data)
    {
        return SoHomeLocation::create($data);
    }

    public function update(SoHomeLocation $soHomeLocation, array $data)
    {
        return $soHomeLocation->update($data);
    }

    public function delete(SoHomeLocation $soHomeLocation)
    {
        return $soHomeLocation->delete();
    }
}