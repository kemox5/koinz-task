<?php

namespace Plugins\SMSGateway\Dto;

use App\Models\User;

class SMSDto{
    public function __construct(public readonly User $user, public readonly string $message)
    {
        
    }
}