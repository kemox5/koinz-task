<?php

namespace Plugins\SMSGateway;

use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\Services\EtislateSMSGateway;
use Plugins\SMSGateway\Services\VodafoneSMSGateway;

class SMSGatewayFactory implements SMSGatewayInterface
{

    public function send(string $phone, string $message): bool
    {
        $gateway = $this->getGateway();

        if ($gateway) {
            try {

                return $gateway->send($phone, $message);

            } catch (\Exception $e) {

                Log::error($e);
                
            }
        }else{

            Log::error('No gateway configuration found!');

        }

        return false;
    }


    public function getGateway(): SMSGatewayInterface | null
    {
        $gateway = config('smsgateway.provider');

        switch ($gateway) {
            case 'vodafone':
                return new VodafoneSMSGateway();
                break;
            case 'etislate':
                return new EtislateSMSGateway();
                break;
        }

        return null;
    }
}
