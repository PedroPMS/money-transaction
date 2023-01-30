<?php

declare(strict_types=1);

namespace MoneyTransaction\Shared\Domain\ValueObject;

use JsonSerializable;

abstract class MoneyValueObject implements JsonSerializable
{
    public function __construct(public int $value)
    {
    }

    public static function fromValue(int $value): static
    {
        return new static($value);
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
