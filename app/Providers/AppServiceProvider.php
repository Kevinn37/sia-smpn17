<?php

// FILE: app/Providers/AppServiceProvider.php
// Service provider utama aplikasi
// SIAKAD SMP Negeri 17 Makassar

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Set locale Carbon ke Indonesia
        // Agar translatedFormat() tampil dalam bahasa Indonesia
        Carbon::setLocale('id');

        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
