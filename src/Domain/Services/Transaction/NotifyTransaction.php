<?php

namespace MoneyTransaction\Domain\Services\Transaction;

use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

interface NotifyTransaction
{
    public function dispatchTransactionNotification(TransactionId $transactionId): void;
}
