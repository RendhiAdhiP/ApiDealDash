<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend:[
            'authMiddleware'=>\App\Http\Middleware\HeaderMiddleware::class, 
        ]);

        $middleware->alias([
            'type.admin' => \App\Http\Middleware\AllAdminMiddlwware::class,
            'type.superadmin' => \App\Http\Middleware\SuperadminMiddlewaare::class,
            'type.adminCreate' => \App\Http\Middleware\AdminCreateMiddleware::class,
            'type.adminView' => \App\Http\Middleware\AdminViewMiddleware::class,
            'type.sales' => \App\Http\Middleware\SalesMiddlwware::class,
        ]);
   

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
