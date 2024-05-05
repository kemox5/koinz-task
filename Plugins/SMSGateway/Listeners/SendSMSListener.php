<?php

namespace Plugins\SMSGateway\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Plugins\SMSGateway\Events\SendSMS;
use Plugins\SMSGateway\SMSGatewayInterface;

class SendSMSListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private SMSGatewayInterface $smsGatewayInterface)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendSMS $event): void
    {
        $this->smsGatewayInterface->send($event->smsDto);
    }
}
