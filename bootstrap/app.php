<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckUserActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckRole::class,
            'active' => CheckUserActive::class,
        ]);

        $middleware->web(append: [
            CheckUserActive::class,
        ]);

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'mahasiswa/chat/*/send',
            'mahasiswa/chat/*/message/*/edit',
            'mahasiswa/chat/*/message/*/delete',
            'dosen/chat/*/send',
            'dosen/chat/*/message/*/edit',
            'dosen/chat/*/message/*/delete',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
