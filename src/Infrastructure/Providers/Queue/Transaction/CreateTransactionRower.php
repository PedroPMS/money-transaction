<?php

namespace MoneyTransaction\Infrastructure\Providers\Queue\Transaction;

use App\Jobs\Transaction\CreateTransaction as CreateTransactionJob;
use Illuminate\Support\Facades\Queue;
use MoneyTransaction\Domain\Services\Transaction\CreateTransaction;

class CreateTransactionRower implements CreateTransaction
{
    public function dispatchTransactionCreate(string $payerId, string $payeeId, int $value): void
    {
        Queue::push(new CreateTransactionJob($payerId, $payeeId, $value));
    }
}
