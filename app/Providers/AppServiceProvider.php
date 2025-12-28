<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LocationService\Search\LocationSearch;
use App\Services\LocationService\Search\ILocationSearch;
use App\Services\LocationService\Geocode\LocationGeocode;
use App\Services\LocationService\Geocode\ILocationGeocode;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(ILocationGeocode::class, LocationGeocode::class);
        $this->app->bind(ILocationSearch::class, LocationSearch::class);
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        //
    }
}
