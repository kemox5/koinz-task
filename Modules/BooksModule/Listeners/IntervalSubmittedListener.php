<?php

namespace Modules\BooksModule\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\BooksModule\Events\IntervalSubmitted;
use Modules\BooksModule\Services\StoreBookReadIntervalService;
use Plugins\SMSGateway\Events\SendSMS;
use Plugins\SMSGateway\SMSGatewayInterface;

class IntervalSubmittedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private StoreBookReadIntervalService $storeBookReadIntervalService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IntervalSubmitted $event): void
    {
        $this->storeBookReadIntervalService->execute($event->bookReadDto);
    }
}
