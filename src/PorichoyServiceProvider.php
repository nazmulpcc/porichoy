<?php

namespace Porichoy;

use Illuminate\Support\ServiceProvider;

class PorichoyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/porichoy.php' => config_path('porichoy.php'),
            ], 'porichoy-config');
        }
    }

    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/porichoy.php', 'porichoy');

        // Register the main class to use with the facade
        $this->app->singleton('porichoy', function () {
            $config = $this->app['config']->get('porichoy');
            return new Porichoy($config['api_host'], $config['api_key']);
        });
    }
}
