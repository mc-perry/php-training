<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ErrorServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        App::bind('errorhandler', function () {
            return new \App\Classes\ErrorHandler;
        });
    }
}
