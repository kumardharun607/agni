<?php

namespace App\Services;

use App\Models\ScrapSeller;
use App\Repositories\ScrapSellerRepository;
use Illuminate\Support\Facades\DB;

class ScrapSellerService
{
    protected $repository;

    public function __construct(ScrapSellerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {

            $this->repository->store($data);

        });
    }

    public function update(ScrapSeller $scrapSeller, array $data)
    {
        DB::transaction(function () use ($scrapSeller, $data) {

            $this->repository->update($scrapSeller, $data);

        });
    }

    public function delete(ScrapSeller $scrapSeller)
    {
        return $this->repository->delete($scrapSeller);
    }
}