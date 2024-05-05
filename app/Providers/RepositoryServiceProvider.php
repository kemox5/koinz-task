<?php

namespace App\Providers;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    const REPOSITORIES = [
        UserRepositoryInterface::class => UserRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (self::REPOSITORIES as $interface => $repo) {
            $this->app->bind($interface, $repo);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
