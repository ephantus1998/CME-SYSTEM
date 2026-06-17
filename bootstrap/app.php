<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register all application middleware aliases
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })
    // FORCE REGISTER THE ADMINS GUARD REGISTRY ON BOOT
    ->booting(function () {
        config([
            'auth.guards.admins' => [
                'driver' => 'session',
                'provider' => 'admins',
            ],
            'auth.providers.admins' => [
                'driver' => 'eloquent',
                'model' => \App\Models\Admin::class,
            ],
        ]);
    })
    ->create();