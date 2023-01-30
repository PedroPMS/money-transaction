<?php

namespace MoneyTransaction\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\Repositories\WalletRepository;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\UserEloquentRepository;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\WalletEloquentRepository;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;
use MoneyTransaction\Shared\Infrastructure\RamseyUuidGenerator;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UuidGeneratorInterface::class, RamseyUuidGenerator::class);
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
        $this->app->bind(WalletRepository::class, WalletEloquentRepository::class);
    }
}
