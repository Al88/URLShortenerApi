<?php

namespace App\Providers;

use App\Repositories\UrlRepository as RepositoriesUrlRepository;
use App\Repositories\UrlRepositoryInterface as RepositoriesUrlRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url): void
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
        $this->app->bind(RepositoriesUrlRepositoryInterface::class, RepositoriesUrlRepository::class);
    }
}
