<?php

namespace Zeyad82\LaravelEnvx;

use Illuminate\Support\ServiceProvider;
use Exception;
use Validator;

class LaravelEnvxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootValidationRule();

        $this->publishes([
            __DIR__ . '/config/envx-validator.php' => config_path('envx-validator.php'),
            __DIR__ . '/envx.example.php' => base_path('envx.example.php'),
        ], 'laravel-envx');
   
        $validator = new EnvxValidator;
        $validator->validate();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/envx-validator.php', 'envx-validator');

        $this->app->singleton('envx', function ($app) {
            return new Envx;
        });
    }

    public function bootValidationRule()
    {
        // required if any of the values of an array equal to a specific value
        Validator::extendImplicit('required_ifany', function ($attribute, $value, $parameters, $validator) {
            $other = array_get($validator->attributes(), $parameters[0]);

            if(is_array($other) && in_array($parameters[1], $other)) {
                return $validator->validateRequired($attribute, $value);
            }

            return true;
        }, 'The :attribute is required if any of :other values is :value');

        Validator::replacer('required_ifany', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':other', ':value'], [$parameters[0], $parameters[1]], $message);
        });
    }
}
