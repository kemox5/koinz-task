<?php

namespace Plugins\SMSGateway;

use Plugins\SMSGateway\Dto\SMSDto;

interface SMSGatewayInterface
{
    public function send(SMSDto $smsDto): bool;
}
