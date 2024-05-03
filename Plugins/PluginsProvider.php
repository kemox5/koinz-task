<?php

namespace Plugins;

use Illuminate\Support\ServiceProvider;

class PluginsProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $plugins = [
            \Plugins\SMSGateway\SMSGatewayProvider::class
        ];

        foreach ($plugins as $plugin) {
            app()->register($plugin);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
