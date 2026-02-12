<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // PENTING: admin routes wajib masuk middleware "web"
            // supaya session/auth bekerja (tidak redirect loop).
            Route::middleware('web')->group(function () {
                require __DIR__ . '/../routes/admin.php';
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Biarkan default (jangan pakai redirectGuestsTo/redirectUsersTo)
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
