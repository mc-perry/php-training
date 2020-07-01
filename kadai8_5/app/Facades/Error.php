<?php

namespace app\Facades;

use Illuminate\Support\Facades\Facade;

class Error extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'errorhandler';
    }
}
