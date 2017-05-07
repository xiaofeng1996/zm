<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Lottery\WinningService;

class WinningServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Lottery\WinningService', function () {
            return new WinningService();
        });
    }
}
