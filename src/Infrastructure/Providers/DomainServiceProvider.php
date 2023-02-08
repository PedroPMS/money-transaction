<?php

namespace MoneyTransaction\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use MoneyTransaction\Domain\Repositories\TransactionRepository;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\Repositories\WalletRepository;
use MoneyTransaction\Domain\Services\Transaction\CreateTransaction;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;
use MoneyTransaction\Domain\Services\Transaction\TransactionAuthorizer;
use MoneyTransaction\Domain\Services\Transaction\TransactionNotifier;
use MoneyTransaction\Infrastructure\Providers\Http\Transaction\TransactionAuthorizerClient;
use MoneyTransaction\Infrastructure\Providers\Http\Transaction\TransactionNotifierClient;
use MoneyTransaction\Infrastructure\Providers\Queue\Transaction\CreateTransactionRower;
use MoneyTransaction\Infrastructure\Providers\Queue\Transaction\NotifyTransactionRower;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\TransactionEloquentRepository;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\UserEloquentRepository;
use MoneyTransaction\Infrastructure\Repositories\Eloquent\WalletEloquentRepository;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;
use MoneyTransaction\Shared\Infrastructure\RamseyUuidGenerator;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UuidGeneratorInterface::class, RamseyUuidGenerator::class);
        $this->app->bind(TransactionAuthorizer::class, TransactionAuthorizerClient::class);
        $this->app->bind(CreateTransaction::class, CreateTransactionRower::class);
        $this->app->bind(NotifyTransaction::class, NotifyTransactionRower::class);
        $this->app->bind(TransactionNotifier::class, TransactionNotifierClient::class);
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
        $this->app->bind(WalletRepository::class, WalletEloquentRepository::class);
        $this->app->bind(TransactionRepository::class, TransactionEloquentRepository::class);
    }
}
