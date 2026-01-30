<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalVariableServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Enregistrez votre variable globale ici
        $this->app->singleton('global_format_date', function () {
            if(env('APP_ENV_2') == 'production') {
                return 'Y-d-m';
            }
            return 'Y-m-d';
        });

        $this->app->singleton('global_format_datetime', function () {
            if(env('APP_ENV_2') == 'production') {
                return 'Y-d-m H:i:s';
            }
            return 'Y-m-d H:i:s';
        });

        $this->app->singleton('global_format_datetime_milisecond', function () {
            if(env('APP_ENV_2') == 'production') {
                return 'Y-d-m H:i:s.v';
            }
            return 'Y-m-d H:i:s.v';
        });
    }
}

