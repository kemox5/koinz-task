<?php

namespace Plugins\SMSGateway;

interface SMSGatewayInterface
{
    public function send(string $phone_number, string $message): bool;
}
