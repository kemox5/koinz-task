<?php

namespace Plugins\SMSGateway\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\Dto\SMSDto;
use Plugins\SMSGateway\SMSGatewayInterface;

class VodafoneSMSGateway implements SMSGatewayInterface
{
    public function send(SMSDto $smsDto): bool
    {

        $url = 'https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719';

        $response = Http::post($url, [
            'phone' => $smsDto->phone_number,
            'message' => $smsDto->message,
        ]);

        if ($response->getStatusCode() == 200) {
            Log::info('VodafoneSMSGateway: SMS sent to ' . $smsDto->phone_number . ' with message ' . $smsDto->message);
            return true;
        }

        return false;
    }
}
