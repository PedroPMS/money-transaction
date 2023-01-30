<?php

namespace MoneyTransaction\Shared\Domain;

interface DbTransactionInterface
{
    public function beginTransaction(): void;

    public function rollBack(): void;

    public function commit(): void;
}
