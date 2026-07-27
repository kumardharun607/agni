<?php

namespace App\Repositories;

use App\Models\ScrapSeller;

class ScrapSellerRepository
{
    public function all()
    {
        return ScrapSeller::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return ScrapSeller::create($data);
    }

    public function update(ScrapSeller $scrapSeller, array $data)
    {
        return $scrapSeller->update($data);
    }

    public function delete(ScrapSeller $scrapSeller)
    {
        return $scrapSeller->delete();
    }
}