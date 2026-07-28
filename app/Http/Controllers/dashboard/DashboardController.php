<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BdeHomeLocation;
use App\Models\Brand;
use App\Models\BuildingStage;
use App\Models\City;
use App\Models\Country;
use App\Models\Dealer;
use App\Models\DealerRegistration;
use App\Models\FloorStage;
use App\Models\Pincode;
use App\Models\SalesStage;
use App\Models\ScrapDistributor;
use App\Models\ScrapSeller;
use App\Models\SoHomeLocation;
use App\Models\State;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'countries' => Country::count(),
            'states' => State::count(),
            'cities' => City::count(),
            'pincodes' => Pincode::count(),
            'dealers' => Dealer::count(),
            'users' => User::count(),
            'salesStages' => SalesStage::count(),
            'scrapDistributors' => ScrapDistributor::count(),
            'scrapSellers' => ScrapSeller::count(),
            'bdeLocations' => BdeHomeLocation::count(),
            'soLocations' => SoHomeLocation::count(),
            'brands' => Brand::count(),
            'floorStages' => FloorStage::count(),
            'buildingStages' => BuildingStage::count(),
            'dealerRegistrations' => DealerRegistration::count(),
        ];

        $activities = [
            'dealers' => Dealer::latest()->take(5)->get(),
            'users' => User::latest()->take(5)->get(),
        ];

        $monthlyStatistics = [
            'countries' => Country::whereMonth('created_at', now()->month)->count(),
            'states' => State::whereMonth('created_at', now()->month)->count(),
            'cities' => City::whereMonth('created_at', now()->month)->count(),
            'pincodes' => Pincode::whereMonth('created_at', now()->month)->count(),
            'dealers' => Dealer::whereMonth('created_at', now()->month)->count(),
            'users' => User::whereMonth('created_at', now()->month)->count(),
            'salesStages' => SalesStage::whereMonth('created_at', now()->month)->count(),
            'scrapDistributors' => ScrapDistributor::whereMonth('created_at', now()->month)->count(),
            'scrapSellers' => ScrapSeller::whereMonth('created_at', now()->month)->count(),
            'bdeLocations' => BdeHomeLocation::whereMonth('created_at', now()->month)->count(),
            'soLocations' => SoHomeLocation::whereMonth('created_at', now()->month)->count(),
            'brands' => Brand::whereMonth('created_at', now()->month)->count(),
            'floorStages' => FloorStage::whereMonth('created_at', now()->month)->count(),
            'buildingStages' => BuildingStage::whereMonth('created_at', now()->month)->count(),
            'dealerRegistrations' => DealerRegistration::whereMonth('created_at', now()->month)->count(),
        ];

        return view('dashboard.index', compact('data', 'activities', 'monthlyStatistics'));
    }
}
