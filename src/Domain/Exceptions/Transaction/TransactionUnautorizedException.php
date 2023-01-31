<?php

namespace MoneyTransaction\Domain\Exceptions\Transaction;

use MoneyTransaction\Shared\Domain\DomainException;
use Throwable;

final class TransactionUnautorizedException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, Throwable $previous = null)
    {
        $message = '' === $message ? 'Transaction unautorized.' : $message;

        parent::__construct($message, $code, $previous);
    }
}
