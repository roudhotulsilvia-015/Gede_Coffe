<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
// Membuat instance aplikasi Laravel dan mengonfigurasinya dengan pengaturan yang diperlukan.
return Application::configure(basePath: dirname(__DIR__))
    // Menentukan jalur untuk file konfigurasi, penyedia layanan, dan alias.
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Menentukan jalur untuk file konfigurasi, penyedia layanan, dan alias.
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    // Menentukan jalur untuk file konfigurasi, penyedia layanan, dan alias.
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
