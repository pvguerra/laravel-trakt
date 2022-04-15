<?php

namespace Pvguerra\LaravelTrakt\Commands;

use Illuminate\Console\Command;

class LaravelTraktCommand extends Command
{
    public $signature = 'laravel-trakt';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
