<?php

namespace Plugins\SMSGateway\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\Dto\SMSDto;
use Plugins\SMSGateway\SMSGatewayInterface;

class EtisalatSMSGateway implements SMSGatewayInterface
{
    public function send(SMSDto $smsDto): bool
    {

        $url = 'https://run.mocky.io/v3/8eb88272-d769-417c-8c5c-159bb023ec0a';

        $response = Http::post($url, [
            'phone' => $smsDto->phone_number,
            'message' => $smsDto->message,
        ]);

        if ($response->getStatusCode() == 200) {
            Log::info('EtisalatSMSGateway: SMS sent to ' . $smsDto->phone_number . ' with message ' . $smsDto->message);
            return true;
        }

        return false;
    }
}
