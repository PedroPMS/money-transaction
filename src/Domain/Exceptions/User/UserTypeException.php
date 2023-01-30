<?php

namespace MoneyTransaction\Domain\Exceptions\User;

use MoneyTransaction\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UserTypeException extends DomainException
{
    public function __construct($message = '', $code = 422, Throwable $previous = null)
    {
        $message = '' === $message ? 'User type not exists' : $message;

        parent::__construct($message, $code, $previous);
    }

    public static function userTypeNotExists(): self
    {
        return new self(
            'User type not exists.',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
