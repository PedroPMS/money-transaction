<?php

namespace MoneyTransaction\Domain\Services\Transaction;

interface CreateTransaction
{
    public function dispatchTransactionCreate(string $payerId, string $payeeId, int $value): void;
}
