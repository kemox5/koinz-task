<?php

namespace Modules\BooksModule\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\BooksModule\Events\IntervalSubmitted;
use Modules\BooksModule\Listeners\IntervalSubmittedListener;

class BooksModuleEventsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(IntervalSubmitted::class, IntervalSubmittedListener::class);
    }
}
