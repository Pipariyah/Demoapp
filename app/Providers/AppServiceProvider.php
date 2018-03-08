<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Demouser;
use App\Observers\DemouserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Demouser::observe(DemouserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
