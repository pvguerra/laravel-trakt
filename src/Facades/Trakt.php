<?php

namespace Pvguerra\LaravelTrakt\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pvguerra\LaravelTrakt\Client
 */
class Trakt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trakt';
    }
}
