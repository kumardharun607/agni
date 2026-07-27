<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        // @userCan('Dealer','add') ... @enduserCan -- hides Add/Edit/Delete/Import/Export
        // buttons per the logged-in user's role permissions (ported from dharun_agni).
        Blade::if('userCan', function (string $feature, string $ability) {
            return userCan($feature, $ability);
        });
    }
}
