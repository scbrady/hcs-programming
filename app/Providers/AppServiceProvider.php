<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Hash;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('old_password', function($attribute, $value, $parameters, $validator) {
            return Hash::check( $value, Auth::user()->password );
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
