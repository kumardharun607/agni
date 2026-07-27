<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use App\Models\Dealer;
use App\Models\User;
use App\Models\SalesStage;
use App\Models\ScrapDistributor;
use App\Models\ScrapSeller;
use App\Models\BdeHomeLocation;
use App\Models\SoHomeLocation;
use App\Models\Brand;
use App\Models\FloorStage;
use App\Models\BuildingStage;
use App\Models\DealerRegistration;

class DashboardRepository
{
    public function getCounts()
    {
        return [
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
    }

    public function recentActivities()
    {
        return collect([])
            ->merge(
                Dealer::latest()->take(3)->get()->map(function ($item) {
                    return ['module' => 'Dealer', 'name' => $item->name ?? ('#' . $item->id), 'date' => $item->created_at];
                })
            )
            ->merge(
                User::latest()->take(3)->get()->map(function ($item) {
                    return ['module' => 'User', 'name' => $item->name, 'date' => $item->created_at];
                })
            )
            ->merge(
                Country::latest()->take(2)->get()->map(function ($item) {
                    return ['module' => 'Country', 'name' => $item->name, 'date' => $item->created_at];
                })
            )
            ->merge(
                State::latest()->take(2)->get()->map(function ($item) {
                    return ['module' => 'State', 'name' => $item->name, 'date' => $item->created_at];
                })
            )
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }

    public function monthlyStatistics()
    {
        return [
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
    }
}
