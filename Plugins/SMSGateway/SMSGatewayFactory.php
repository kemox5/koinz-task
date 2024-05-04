<?php

namespace Plugins\SMSGateway;

use Illuminate\Support\Facades\Log;

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
