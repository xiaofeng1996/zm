<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['web.layout.shared.top', 'web.home.index'],
            'App\Http\ViewComposers\UserComposer'
        );
        View::composer(
            'web.layout.shared.header', 'App\Http\ViewComposers\HeaderComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
