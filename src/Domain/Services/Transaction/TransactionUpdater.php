<?php

namespace MoneyTransaction\Domain\Services\Transaction;

use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Repositories\TransactionRepository;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

class TransactionUpdater
{
    public function __construct(
        private readonly TransactionRepository $repository,
    ) {
    }

    public function updateTransactionStatus(TransactionId $transactionId, TransactionStatus $newStatus): void
    {
        $this->repository->updateStatus($transactionId, $newStatus);
    }
}
