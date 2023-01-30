<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class UserDeletor
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function deleteUser(UserId $id): void
    {
        $user = $this->repository->findById($id);

        if (! $user) {
            throw new UserNotFoundException();
        }

        $this->repository->delete($id);
    }
}
