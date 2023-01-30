<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoneyTransaction\Infrastructure\Providers\DomainServiceProvider;
use MoneyTransaction\Presentation\Http\Routes\Router;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(DomainServiceProvider::class);
        $this->app->register(Router::class);
    }
}
