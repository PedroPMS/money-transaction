<?php

namespace MoneyTransaction\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\UserEloquentRepository;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;
use MoneyTransaction\Shared\Infrastructure\RamseyUuidGenerator;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UuidGeneratorInterface::class, RamseyUuidGenerator::class);
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
    }
}
