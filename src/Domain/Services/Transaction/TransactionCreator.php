<?php

namespace MoneyTransaction\Domain\Services\Transaction;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Repositories\TransactionRepository;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class TransactionCreator
{
    public function __construct(private readonly TransactionRepository $repository)
    {
    }

    public function createTransaction(
        TransactionId $id,
        UserId $payerId,
        UserId $payeeId,
        TransactionValue $value,
        TransactionStatus $status
    ): Transaction {
        $transaction = Transaction::create($id, $payerId, $payeeId, $value, $status);

        $this->repository->create($transaction);

        return $transaction;
    }
}
