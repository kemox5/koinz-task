<?php

namespace Plugins\SMSGateway\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\SMSGatewayInterface;

class VodafoneSMSGateway implements SMSGatewayInterface
{
    public function send(string $phone, string $message): bool
    {

        $url = 'https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719';

        $response = Http::post($url, [
            'phone' => $phone,
            'message' => $message,
        ]);

        if ($response->getStatusCode() == 200) {
            Log::info('VodafoneSMSGateway: SMS sent to ' . $phone . ' with message ' . $message);
            return true;
        }

        return false;
    }
}
