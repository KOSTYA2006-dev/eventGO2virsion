<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Только для production или если явно указан HTTPS в APP_URL
        $appUrl = config('app.url', '');
        $isProduction = config('app.env') === 'production';
        $isLocal = config('app.env') === 'local' || str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1');
        
        // Не принуждаем HTTPS для локальной разработки
        if ($isLocal) {
            return;
        }
        
        // Принудительно использовать HTTPS в production
        if ($isProduction) {
            \URL::forceScheme('https');
            return;
        }
        
        // Автоматическое определение HTTPS через прокси (Railway, Cloudflare и т.д.)
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \URL::forceScheme('https');
            return;
        }
        
        // Также проверяем заголовок X-Forwarded-Ssl
        if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
            \URL::forceScheme('https');
            return;
        }
        
        // Если APP_URL содержит https, принудительно используем HTTPS
        if (str_starts_with($appUrl, 'https://')) {
            \URL::forceScheme('https');
        }
    }
}
