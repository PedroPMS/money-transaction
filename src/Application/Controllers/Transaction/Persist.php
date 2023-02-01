<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Services\Transaction\TransactionCreator;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;

class Persist
{
    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly TransactionCreator $transactionCreator,
    ) {
    }

    public function persistTransaction(string $payerId, string $payeeId, int $value): Transaction
    {
        $id = TransactionId::fromValue($this->uuidGenerator->generate());
        $payerId = UserId::fromValue($payerId);
        $payeeId = UserId::fromValue($payeeId);
        $value = TransactionValue::fromValue($value);
        $status = TransactionStatus::CREATED;

        return $this->transactionCreator->createTransaction($id, $payerId, $payeeId, $value, $status);
    }
}
