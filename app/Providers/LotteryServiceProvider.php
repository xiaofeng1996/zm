<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Lottery\LotteryService;

class LotteryServiceProvider extends ServiceProvider
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
        $this->app->bind('Lottery\LotteryService', function ($app) {
            return new LotteryService();
        });
    }
}
