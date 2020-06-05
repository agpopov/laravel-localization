<?php

namespace agpopov\localization;

use agpopov\localization\Middleware\LocalizationMiddleware;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        app()->middleware([LocalizationMiddleware::class]);
    }
}
