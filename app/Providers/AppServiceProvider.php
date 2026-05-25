<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $appUrl = config('app.url', '');
        $isProduction = config('app.env') === 'production';
        $isLocal = config('app.env') === 'local' || str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1');

        if ($isLocal) {
            return;
        }

        if ($isProduction) {
            \URL::forceScheme('https');
            return;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \URL::forceScheme('https');
            return;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
            \URL::forceScheme('https');
            return;
        }

        if (str_starts_with($appUrl, 'https://')) {
            \URL::forceScheme('https');
        }
    }
}
