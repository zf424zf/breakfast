<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\Settings as SettingsService;
use App\Http\Services\User;

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
        app()->singleton('user', function ($app) {
            return new User;
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
