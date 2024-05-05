<?php

namespace Modules\BooksModule\Providers;

use Illuminate\Support\ServiceProvider;


class BooksModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->publishes([__DIR__ . '/../Database/migrations/' => database_path('migrations')], 'migrations');

        $this->app->register(BooksModuleRouteServiceProvider::class);
        $this->app->register(BooksModuleRepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
