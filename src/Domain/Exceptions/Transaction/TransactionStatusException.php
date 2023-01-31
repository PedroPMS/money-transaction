<?php

namespace MoneyTransaction\Domain\Exceptions\Transaction;

use MoneyTransaction\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class TransactionStatusException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, Throwable $previous = null)
    {
        $message = '' === $message ? 'User type not exists' : $message;

        parent::__construct($message, $code, $previous);
    }

    public static function transactionStatusNotExists(): self
    {
        return new self(
            'Transaction status not exists.',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
