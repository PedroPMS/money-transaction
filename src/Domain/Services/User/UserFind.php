<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class UserFind
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUser(UserId $id): User
    {
        $user = $this->repository->findById($id);

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
