<?php

namespace Plugins\SMSGateway;

use Illuminate\Support\ServiceProvider;

class SMSGatewayProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->publishes([__DIR__ . '/config/sms.php' => config_path('sms.php')], 'configs');

        $this->app->bind(SMSGatewayInterface::class, SMSGatewayFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
