<?php

namespace MoneyTransaction\Domain\Repositories;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

interface TransactionRepository
{
    public function findById(TransactionId $id): ?Transaction;

    public function create(Transaction $transaction): void;

    public function updateStatus(TransactionId $transactionId, TransactionStatus $newStatus): void;
}
