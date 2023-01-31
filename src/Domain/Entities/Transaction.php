<?php

namespace MoneyTransaction\Domain\Entities;

use JsonSerializable;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionStatusException;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class Transaction implements JsonSerializable
{
    public function __construct(
        public readonly TransactionId $id,
        public readonly UserId $payerId,
        public readonly UserId $payeeId,
        public readonly TransactionValue $value,
        public readonly TransactionStatus $status
    ) {
    }

    /**
     * @throws TransactionStatusException
     */
    public static function fromPrimitives(string $id, string $payerId, string $payeeId, int $value, string $status): self
    {
        return new self(
            TransactionId::fromValue($id),
            UserId::fromValue($payerId),
            UserId::fromValue($payeeId),
            TransactionValue::fromValue($value),
            TransactionStatus::fromValue($status)
        );
    }

    public static function create(TransactionId $id, UserId $payerId, UserId $payeeId, TransactionValue $value, TransactionStatus $status): self
    {
        return new self($id, $payerId, $payeeId, $value, $status);
    }

    /** @return array<string, string|int> */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'payer_id' => $this->payerId,
            'payee_id' => $this->payeeId,
            'value' => $this->value->value(),
            'status' => $this->status,
        ];
    }
}
