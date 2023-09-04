<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class AnonymousMigration extends Command
{
    protected $signature = 'make:amigration';
    protected $description = '';

    public function handle(): void
    {
        Artisan::call('make:migration ' . time());
    }
}
