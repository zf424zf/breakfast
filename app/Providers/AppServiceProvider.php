<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\Settings as SettingsService;
use App\Http\Services\User;
use App\Util\Validator as ExtendValidator;

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
        //重置校验类库为自定义扩展
        app('validator')->resolver(function ($translator, $data, $rules, $messages) {
            $instance = new ExtendValidator($translator, $data, $rules, $messages);
            return $instance;
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
