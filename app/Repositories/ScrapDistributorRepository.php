<?php

namespace App\Repositories;

use App\Models\ScrapDistributor;

class ScrapDistributorRepository
{
    public function all()
    {
        return ScrapDistributor::with([
            'country',
            'state',
            'city'
        ])
        ->latest()
        ->paginate(10);
    }

    public function store(array $data)
    {
        return ScrapDistributor::create($data);
    }

    public function update(ScrapDistributor $scrapDistributor,array $data)
    {
        return $scrapDistributor->update($data);
    }

    public function delete(ScrapDistributor $scrapDistributor)
    {
        return $scrapDistributor->delete();
    }
}