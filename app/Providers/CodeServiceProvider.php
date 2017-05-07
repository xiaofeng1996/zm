<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Code\CodeService;

class CodeServiceProvider extends ServiceProvider
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
        $this->app->bind('Code\CodeService', function ($app) {
            return new CodeService();
        });
    }
}
