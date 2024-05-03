<?php

namespace Plugins\SMSGateway\Services;

use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\SmsGatewayInterface;

class VodafoneSMSGateway implements SmsGatewayInterface
{
    public function send(string $phone, string $message): bool
    {

        $url = 'https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719';

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'body' => json_encode([
                'phone' => $phone,
                'message' => $message,
            ])
        ]);

        if($response->getStatusCode() == 200){
            Log::info('VodafoneSMSGateway: SMS sent to '. $phone. ' with message '. $message);
            return true;
        }

        return false;
    }
}
