<?php

namespace App\Providers;

use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\DealerMappingRepository;
use App\Repositories\Eloquent\DealerRepository;
use App\Repositories\Eloquent\PermissionDropdownRepository;
use App\Repositories\Eloquent\PincodeRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\SalesStageRepository;
use App\Repositories\Eloquent\StateRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\DealerMappingRepositoryInterface;
use App\Repositories\Interfaces\DealerRepositoryInterface;
use App\Repositories\Interfaces\PermissionDropdownRepositoryInterface;
use App\Repositories\Interfaces\PincodeRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\SalesStageRepositoryInterface;
use App\Repositories\Interfaces\StateRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(PincodeRepositoryInterface::class, PincodeRepository::class);
        $this->app->bind(DealerRepositoryInterface::class, DealerRepository::class);
        $this->app->bind(DealerMappingRepositoryInterface::class, DealerMappingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionDropdownRepositoryInterface::class, PermissionDropdownRepository::class);
        $this->app->bind(SalesStageRepositoryInterface::class, SalesStageRepository::class);
    }

    public function boot(): void
    {
    }
}
