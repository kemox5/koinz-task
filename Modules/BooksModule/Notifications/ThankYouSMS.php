<?php

namespace Modules\BooksModule\Notifications;

use App\Interfaces\Repositories\UserRepositoryInterface;
use Plugins\SMSGateway\Dto\SMSDto;
use Plugins\SMSGateway\Events\SendSMS;
use Plugins\SMSGateway\SMSGatewayInterface;

class ThankYouSMS
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function send($user_id)
    {
        $user = $this->userRepository->getById($user_id);

        

        SendSMS::dispatch(new SMSDto($user, 'Thank you for your submition!'));
    }
}
