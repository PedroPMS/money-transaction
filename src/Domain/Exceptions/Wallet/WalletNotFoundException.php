<?php

namespace MoneyTransaction\Domain\Exceptions\Wallet;

use MoneyTransaction\Shared\Domain\DomainException;
use Throwable;

final class WalletNotFoundException extends DomainException
{
    public function __construct($message = '', $code = 404, Throwable $previous = null)
    {
        $message = '' === $message ? 'Wallet not found' : $message;

        parent::__construct($message, $code, $previous);
    }
}
