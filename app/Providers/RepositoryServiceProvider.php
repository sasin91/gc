<?php

namespace App\Providers;

use App\Repositories\FriendsRepository;
use App\Repositories\FriendsRepositoryContract;
use App\Repositories\ServerRepository;
use App\Repositories\ServerRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            FriendsRepositoryContract::class,
            FriendsRepository::class
        );

        $this->app->bind(
            ServerRepositoryContract::class,
            ServerRepository::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            FriendsRepositoryContract::class,
            ServerRepositoryContract::class
        ];
    }
}