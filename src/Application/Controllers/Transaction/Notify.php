<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Services\Transaction\TransactionNotifier;

class Notify
{
    public function __construct(private readonly TransactionNotifier $notifier)
    {
    }

    public function notify(): void
    {
        $this->notifier->sendNotification();
    }
}
