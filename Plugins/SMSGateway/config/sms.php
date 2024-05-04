<?php

return [
    'provider' => env('SMS_PROVIDER'),
    'providers_list' => [
        'vodafone' => \Plugins\SMSGateway\Services\VodafoneSMSGateway::class,
        'etisalat' => \Plugins\SMSGateway\Services\EtisalatSMSGateway::class
    ]
];
