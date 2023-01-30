<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Collections\User\Users;
use MoneyTransaction\Domain\Repositories\UserRepository;

class UsersGet
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function getUsers(): Users
    {
        return $this->repository->getAll();
    }
}
