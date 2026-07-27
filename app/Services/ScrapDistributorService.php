<?php

namespace App\Services;

use App\Models\ScrapDistributor;
use App\Repositories\ScrapDistributorRepository;
use Illuminate\Support\Facades\DB;

class ScrapDistributorService
{
    protected $repository;

    public function __construct(ScrapDistributorRepository $repository)
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

    public function update(ScrapDistributor $scrapDistributor,array $data)
    {
        DB::transaction(function () use ($scrapDistributor,$data) {

            $this->repository->update($scrapDistributor,$data);

        });
    }

    public function delete(ScrapDistributor $scrapDistributor)
    {
        return $this->repository->delete($scrapDistributor);
    }
}