<?php

declare(strict_types=1);

namespace MoneyTransaction\Shared\Domain\ValueObject;

use JsonSerializable;

abstract class StringValueObject implements JsonSerializable
{
    public function __construct(public string $value)
    {
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
