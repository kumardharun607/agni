<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    protected $repository;

    public function __construct(
        DashboardRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function dashboardData()
    {
        return $this->repository->getCounts();
    }

    public function recentActivities()
    {
        return $this->repository->recentActivities();
    }

    public function monthlyStatistics()
    {
        return $this->repository->monthlyStatistics();
    }
}