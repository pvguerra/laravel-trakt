<?php

namespace Pvguerra\LaravelTrakt\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pvguerra\LaravelTrakt\LaravelTrakt
 */
class LaravelTrakt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-trakt';
    }
}
