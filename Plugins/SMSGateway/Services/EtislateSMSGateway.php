<?php

namespace Plugins\SMSGateway\Services;

use Illuminate\Support\Facades\Log;
use Plugins\SMSGateway\SmsGatewayInterface;

class EtislateSMSGateway implements SmsGatewayInterface
{
    public function send(string $phone, string $message): bool
    {

        $url = 'https://run.mocky.io/v3/8eb88272-d769-417c-8c5c-159bb023ec0a';

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'body' => json_encode([
                'phone' => $phone,
                'message' => $message,
            ])
        ]);

        if($response->getStatusCode() == 200){
            Log::info('EtislateSMSGateway: SMS sent to '. $phone. ' with message '. $message);
            return true;
        }

        return false;
    }
}
