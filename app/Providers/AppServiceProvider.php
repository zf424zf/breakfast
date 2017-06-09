<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Service\Settings as SettingsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->singleton('setting', function ($app) {
            return new SettingsService;
        });
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
