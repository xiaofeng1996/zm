<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\Web\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Web\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'ajaxCheckLogin' => [
            \App\Http\Middleware\Web\CheckLoginForAjax::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],

        'apiCheckLogin' => [
            \App\Http\Middleware\Api\CheckLogin::class,
        ],

        'webCheckLogin' => [
            \App\Http\Middleware\Web\CheckLogin::class,
        ],

        'adminCheckLogin' => [
            \App\Http\Middleware\Admin\CheckLogin::class,
        ],

        'adminCheckMaster' => [
            \App\Http\Middleware\Admin\CheckMaster::class,
        ],

        'admin' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Admin\VerifyCsrfToken::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\Web\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'checkCode' => \App\Http\Middleware\CheckCode::class,
    ];
}
