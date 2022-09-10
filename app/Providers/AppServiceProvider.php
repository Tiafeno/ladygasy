<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('phone_valid', function($attr, $data) {
          try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $swissNumber = $phoneUtil->parse($data, "MG");
            if ($phoneUtil->isValidNumber($swissNumber)) {
              return true;
            }
            return false;
          } catch(NumberParseException $e) {
            return false;
          }
        });
    }
}
