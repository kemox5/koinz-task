<?php

namespace Modules\BooksModule\Notifications;

use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
        // send only one sms per day per user
        if (Cache::has('thank_you_sms_user_id' . $user_id) === false) {

            $user = $this->userRepository->getById($user_id);

            Cache::add('thank_you_sms_user_id' . $user_id, true, (24 * 60 * 60));

            SendSMS::dispatch(new SMSDto($user, 'Thank you for your submition!'));
        }
    }
}
