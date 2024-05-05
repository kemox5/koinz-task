<?php

namespace Plugins\SMSGateway;

use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\Dto\SMSDto;

class SMSGatewayFactory implements SMSGatewayInterface
{

    public function send(SMSDto $smsDto): bool
    {
        $gateway = $this->getGateway();

        if ($gateway) {
            try {

                return $gateway->send($smsDto);
            } catch (\Exception $e) {

                Log::error($e);
            }
        } else {

            Log::error('No gateway configuration found!');
        }

        return false;
    }


    public function getGateway(): SMSGatewayInterface | null
    {
        $gateway = config('sms.provider');
        $gateways_list = config('sms.providers_list');

        if (isset($gateways_list[$gateway]) && class_exists($gateways_list[$gateway])) {
            return new $gateways_list[$gateway];
        }

        return null;
    }
}
