<?php

namespace MoneyTransaction\Infrastructure\Providers\Queue\Transaction;

use App\Jobs\Transaction\NotifyTransaction as NotifyTransactionJob;
use Illuminate\Support\Facades\Queue;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;

class NotifyTransactionRower implements NotifyTransaction
{
    public function dispatchTransactionNotification(): void
    {
        Queue::push(new NotifyTransactionJob());
    }
}
