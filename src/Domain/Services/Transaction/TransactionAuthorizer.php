<?php

namespace MoneyTransaction\Domain\Services\Transaction;

interface TransactionAuthorizer
{
    public function isAutorized(): bool;
}
