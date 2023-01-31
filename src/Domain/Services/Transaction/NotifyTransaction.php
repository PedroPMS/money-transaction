<?php

namespace MoneyTransaction\Domain\Services\Transaction;

interface NotifyTransaction
{
    public function dispatchTransactionNotification(): void;
}
