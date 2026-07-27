<?php

namespace App\Services;

use App\Models\SoHomeLocation;
use App\Repositories\SoHomeLocationRepository;
use Illuminate\Support\Facades\DB;

class SoHomeLocationService
{
    protected $repository;

    public function __construct(SoHomeLocationRepository $repository)
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

    public function update(SoHomeLocation $soHomeLocation, array $data)
    {
        DB::transaction(function () use ($soHomeLocation, $data) {

            $this->repository->update($soHomeLocation, $data);

        });
    }

    public function delete(SoHomeLocation $soHomeLocation)
    {
        return $this->repository->delete($soHomeLocation);
    }
}