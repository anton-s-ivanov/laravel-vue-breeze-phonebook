<?php

namespace App\Providers;

use App\Repositories\ContactRepository;
use App\Repositories\HomePageRepository;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Repositories\Interfaces\HomePageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            HomePageRepositoryInterface::class,
            HomePageRepository::class
        );

        $this->app->bind(
            ContactRepositoryInterface::class,
            ContactRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
