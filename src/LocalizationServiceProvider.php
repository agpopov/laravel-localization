<?php

namespace agpopov\localization;

use agpopov\localization\Middleware\LocalizationMiddleware;
use agpopov\localization\Models\Language;
use agpopov\localization\Repositories\CachingLanguageRepository;
use agpopov\localization\Repositories\LanguageRepository;
use agpopov\localization\Repositories\LanguageRepositoryInterface;
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
        $this->app->singleton(LanguageRepositoryInterface::class, function () {
            $baseRepo = new LanguageRepository(new Language());
            return new CachingLanguageRepository($baseRepo);
        });
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
