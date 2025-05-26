<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use App\Middleware\Cors::class;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: base_path('routes/console.php'),
        health: '/up',
        using: function() {

            Route::prefix('v1')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

            Route::prefix('admin')
            ->middleware('web')
            ->group(base_path('routes/admin.php'));

            Route::middleware('web')
            ->group(base_path('routes/web.php'));
        }
    )->withMiddleware(function (Middleware $middleware) {
        //
        // 'cors'          => \App\Http\Middleware\Cors::class, // added
        $middleware->redirectGuestsTo('/auth/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
