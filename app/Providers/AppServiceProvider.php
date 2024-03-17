<?php

namespace App\Providers;

use App\Jobs\NotifySubscribersJob;
use App\Services\PriceParsingService;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SubscriptionService::class, function ($app) {
            return new SubscriptionService();
        });

        $this->app->bind(PriceParsingService::class, function ($app) {
            return new PriceParsingService();
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
