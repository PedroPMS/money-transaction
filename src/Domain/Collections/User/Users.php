<?php

namespace MoneyTransaction\Domain\Collections\User;

use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Shared\Domain\AbstractCollection;

final class Users extends AbstractCollection
{
    protected function type(): string
    {
        return User::class;
    }
}
