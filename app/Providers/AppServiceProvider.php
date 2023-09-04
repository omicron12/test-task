<?php

namespace App\Providers;

use App\Services\AppService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('app-service', fn() => new AppService());
    }

    public function boot(): void
    {

    }

}
