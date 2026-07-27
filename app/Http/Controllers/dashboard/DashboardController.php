<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    protected $dashboardRepository;


    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }


    public function index()
    {
        $data = $this->dashboardRepository->getCounts();

        $activities = $this->dashboardRepository->recentActivities();

        $monthlyStatistics = $this->dashboardRepository->monthlyStatistics();


        return view('dashboard.index', compact(
            'data',
            'activities',
            'monthlyStatistics'
        ));
    }
}