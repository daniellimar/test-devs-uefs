<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\{PostRepository, UserRepository, TagRepository};
use App\Repositories\Contracts\{PostRepositoryInterface, TagRepositoryInterface, UserRepositoryInterface};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
