<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
    public function boot()
    {
        Validator::extend('not_start_with_zero', function ($attribute, $value, $parameters, $validator) {
            return !preg_match('/^0/', $value);
        });

        Validator::replacer('not_start_with_zero', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The  field cannot start with zero.');
        });
    }
}
