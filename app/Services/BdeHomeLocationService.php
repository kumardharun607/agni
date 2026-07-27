<?php

namespace App\Services;

use App\Models\BdeHomeLocation;
use App\Repositories\BdeHomeLocationRepository;
use Illuminate\Support\Facades\DB;

class BdeHomeLocationService
{
    protected $repository;

    public function __construct(BdeHomeLocationRepository $repository)
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

    public function update(BdeHomeLocation $location, array $data)
    {
        DB::transaction(function () use ($location, $data) {

            $this->repository->update($location, $data);

        });
    }

    public function delete(BdeHomeLocation $location)
    {
        return $this->repository->delete($location);
    }
}