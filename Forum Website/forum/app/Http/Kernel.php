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
        // ...existing middleware...
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // ...existing middleware...
        ],

        'api' => [
            // ...existing middleware...
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ...existing middleware...
    ];

    /**
     * The application's middleware aliases.
     *
     * These middleware aliases may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $middlewareAliases = [
        // ...existing middleware aliases...
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
    ];
}