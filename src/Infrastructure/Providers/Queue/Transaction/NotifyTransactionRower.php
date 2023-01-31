<?php

namespace MoneyTransaction\Infrastructure\Providers\Queue\Transaction;

use App\Jobs\Transaction\NotifyTransaction as NotifyTransactionJob;
use Illuminate\Support\Facades\Queue;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

class NotifyTransactionRower implements NotifyTransaction
{
    public function dispatchTransactionNotification(TransactionId $transactionId): void
    {
        Queue::push(new NotifyTransactionJob($transactionId));
    }
}
