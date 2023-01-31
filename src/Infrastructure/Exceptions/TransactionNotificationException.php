<?php

namespace MoneyTransaction\Infrastructure\Exceptions;

use MoneyTransaction\Shared\Infrastructure\InfrastructureException;
use Throwable;

final class TransactionNotificationException extends InfrastructureException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        $message = '' === $message ? 'Error in send notification' : $message;

        parent::__construct($message, $code, $previous);
    }
}
