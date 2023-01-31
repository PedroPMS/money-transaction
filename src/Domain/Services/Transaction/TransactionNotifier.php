<?php

namespace MoneyTransaction\Domain\Services\Transaction;

interface TransactionNotifier
{
    public function sendNotification(): void;
}
