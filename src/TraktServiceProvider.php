<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Pvguerra\LaravelTrakt\Client;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('trakt')
            ->hasConfigFile();
    }
    
    public function packageRegistered(): void
    {
        $this->app->singleton('trakt', function ($app) {
            return new Client();
        });
        
        $this->app->bind(ClientInterface::class, Client::class);
    }
}
