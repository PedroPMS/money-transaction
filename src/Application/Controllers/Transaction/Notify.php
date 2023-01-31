<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Services\Transaction\TransactionNotifier;
use MoneyTransaction\Domain\Services\Transaction\TransactionUpdater;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

class Notify
{
    public function __construct(
        private readonly TransactionNotifier $notifier,
        private readonly TransactionUpdater $transactionUpdater
    ) {
    }

    public function notify(TransactionId $transactionId): void
    {
        $this->notifier->sendNotification();
        $this->transactionUpdater->markAsNotified($transactionId);
    }
}
