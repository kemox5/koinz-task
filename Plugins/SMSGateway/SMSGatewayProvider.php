<?php

namespace Plugins\SMSGateway;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Plugins\SMSGateway\Events\SendSMS;
use Plugins\SMSGateway\Listeners\SendSMSListener;

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
        Event::listen(
            SendSMS::class,
            SendSMSListener::class,
        );
    }
}
