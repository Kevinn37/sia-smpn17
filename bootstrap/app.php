<?php

// FILE: bootstrap/app.php
// Konfigurasi aplikasi Laravel 11
// SIAKAD SMP Negeri 17 Makassar

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Pastikan folder cache dialihkan ke folder /tmp jika berjalan di server Vercel
$basePath = dirname(__DIR__);
$app = Application::configure(basePath: $basePath);

if (isset($_SERVER['VERCEL_JWT']) || env('APP_ENV') === 'production') {
    $app->useStoragePath('/tmp/storage');
    $app->useBootstrapCachePath('/tmp/bootstrap/cache');
}

return $app
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Daftarkan RoleMiddleware dengan alias 'role'
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
