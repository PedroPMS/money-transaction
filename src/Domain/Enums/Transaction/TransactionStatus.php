<?php

namespace MoneyTransaction\Domain\Enums\Transaction;

use MoneyTransaction\Domain\Exceptions\Transaction\TransactionStatusException;

enum TransactionStatus: string
{
    case CREATED = 'created';
    case DEBITED = 'debited';
    case SUCCEEDED = 'succeeded';
    case REJECTED = 'rejected';

    /**
     * @throws TransactionStatusException
     */
    public static function fromValue(string $value): self
    {
        return match ($value) {
            self::CREATED->value => self::CREATED,
            self::DEBITED->value => self::DEBITED,
            self::SUCCEEDED->value => self::SUCCEEDED,
            self::REJECTED->value => self::REJECTED,
            default => throw TransactionStatusException::transactionStatusNotExists(),
        };
    }
}
