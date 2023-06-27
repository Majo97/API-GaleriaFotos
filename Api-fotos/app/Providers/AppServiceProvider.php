<?php

namespace App\Providers;

use App\Http\Controllers\CollectionController;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Services\CollectionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });
        $this->app->singleton(  CollectionService::class, function ($app) {
            return new CollectionService();
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
