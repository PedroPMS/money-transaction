<?php

namespace MoneyTransaction\Domain\Exceptions\Transaction;

use MoneyTransaction\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class PayerDoesntHaveEnoughBalanceException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, Throwable $previous = null)
    {
        $message = '' === $message ? "User doesn't have enough balance for transaction." : $message;

        parent::__construct($message, $code, $previous);
    }

    public static function payerDoesntHaveEnoughBalance(): self
    {
        return new self(
            "You doesn't have enough balance for transaction.",
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
