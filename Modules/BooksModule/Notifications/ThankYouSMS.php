<?php

namespace Modules\BooksModule\Notifications;

use App\Interfaces\Repositories\UserRepositoryInterface;
use Plugins\SMSGateway\SMSGatewayInterface;

class ThankYouSMS
{
    public function __construct(private SMSGatewayInterface $smsGateway, private UserRepositoryInterface $userRepository)
    {
    }

    public function send($user_id)
    {
        $user = $this->userRepository->getById($user_id);
        $sms = 'Thank you for your submition!';
        return $this->smsGateway->send($user->phone_number, $sms);
    }
}
