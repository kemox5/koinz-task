<?php

namespace Plugins\SMSGateway\Dto;

class SMSDto{
    public function __construct(public readonly string $phone_number, public readonly string $message)
    {
        
    }
}