<?php

namespace Wayl;

use Illuminate\Support\ServiceProvider;

class WaylServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wayl.php', 'wayl');

        $this->app->singleton(Wayl::class, function ($app) {
            return new Wayl(
                config('wayl.api_key'),
                config('wayl.base_url')
            );
        });

        $this->app->alias(Wayl::class, 'wayl');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/wayl.php' => config_path('wayl.php'),
            ], 'wayl-config');
        }
    }
}

