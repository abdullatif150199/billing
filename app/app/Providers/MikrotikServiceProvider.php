<?php

namespace App\Providers;

use App\Models\DataMaster;
use App\Services\MikrotikService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MikrotikServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MikrotikService::class, function (Application $app) {
            $config = DataMaster::where('nama', 'mikrotik')->first();
            $config = json_decode($config->data, true);

            return new MikrotikService($config);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
