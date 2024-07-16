<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LocationsImportService;

class LocationsImportServiceProvider extends ServiceProvider
{

    /**
     * Register the Locations import Service provider
     */
    public function register(): void
    {
        $this->app->singleton(LocationsImportService::class, function () {
            return new LocationsImportService;
        });
    }
}
