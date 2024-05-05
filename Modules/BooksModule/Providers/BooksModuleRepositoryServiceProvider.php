<?php

namespace Modules\BooksModule\Providers;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Modules\BooksModule\Interfaces\Repositories\BookReadRepositoryInterface;
use Modules\BooksModule\Interfaces\Repositories\BookRepositoryInterface;
use Modules\BooksModule\Repositories\BookReadRepository;
use Modules\BooksModule\Repositories\BookRepository;

class BooksModuleRepositoryServiceProvider extends ServiceProvider
{

    const REPOSITORIES = [
        BookRepositoryInterface::class => BookRepository::class,
        BookReadRepositoryInterface::class => BookReadRepository::class
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
