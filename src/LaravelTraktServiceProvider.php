<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Commands\LaravelTraktCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelTraktServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-trakt')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-trakt_table')
            ->hasCommand(LaravelTraktCommand::class);
    }
}
