<?php

declare(strict_types=1);

namespace MoneyTransaction\Shared\Domain;

use Exception;

abstract class DomainException extends Exception
{
    /** @var int */
    protected $code = 400;
}
