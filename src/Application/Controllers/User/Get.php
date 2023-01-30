<?php

namespace MoneyTransaction\Application\Controllers\User;

use MoneyTransaction\Application\Resources\User\UsersResponse;
use MoneyTransaction\Domain\Services\User\UsersGet;

class Get
{
    public function __construct(private readonly UsersGet $usersGet)
    {
    }

    public function getUsers(): UsersResponse
    {
        $users = $this->usersGet->getUsers();

        return UsersResponse::fromUsers($users);
    }
}
