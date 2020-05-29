<?php

namespace agpopov\localization;

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
        app()->routeMiddleware([
            'web' => agpopov\localization\Middleware\LocalizationMiddleware::class,
        ]);
    }
}
