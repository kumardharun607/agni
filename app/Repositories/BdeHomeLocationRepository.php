<?php

namespace App\Repositories;

use App\Models\BdeHomeLocation;

class BdeHomeLocationRepository
{
    public function all()
    {
        return BdeHomeLocation::with([
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
        return BdeHomeLocation::create($data);
    }

    public function update(BdeHomeLocation $location, array $data)
    {
        return $location->update($data);
    }

    public function delete(BdeHomeLocation $location)
    {
        return $location->delete();
    }
}