<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Definisikan middleware group untuk API
        $middleware->group('api', [
            // Middleware Sanctum — untuk handle stateful SPA / token
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // Batasi request API (misal 60x per menit)
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',

            // Pastikan binding route (misal model binding) aktif
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // (Opsional) Jika kamu ingin middleware global (berlaku di semua route)
        // $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Kamu bisa custom error handler di sini (misal JSON error response)
    })
    ->create();
