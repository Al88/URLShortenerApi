<?php

namespace App\Providers;

use App\Repositories\UrlRepository as RepositoriesUrlRepository;
use App\Repositories\UrlRepositoryInterface as RepositoriesUrlRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(RepositoriesUrlRepositoryInterface::class, RepositoriesUrlRepository::class);
    }
}