<?php

namespace MoneyTransaction\Domain\Exceptions\Transaction;

use MoneyTransaction\Shared\Domain\DomainException;
use Throwable;

final class TransactionNotFoundException extends DomainException
{
    public function __construct(string $message = '', int $code = 404, Throwable $previous = null)
    {
        $message = '' === $message ? 'Transaction not found' : $message;

        parent::__construct($message, $code, $previous);
    }
}
