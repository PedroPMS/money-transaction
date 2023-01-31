<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoneyTransaction\Infrastructure\Providers\DomainServiceProvider;
use MoneyTransaction\Presentation\Http\Routes\Router;
use MoneyTransaction\Shared\Domain\DbTransactionInterface;
use MoneyTransaction\Shared\Infrastructure\EloquentDbTransaction;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(DomainServiceProvider::class);
        $this->app->register(Router::class);

        $this->app->singleton(DbTransactionInterface::class, EloquentDbTransaction::class);
    }
}
