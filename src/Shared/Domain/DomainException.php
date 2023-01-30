<?php

declare(strict_types=1);

namespace MoneyTransaction\Shared\Domain;

use Exception;

abstract class DomainException extends Exception
{
    protected $code = 400;
}
