<?php

namespace MoneyTransaction\Application\Controllers\User;

use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Services\User\UserDeletor;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class Delete
{
    public function __construct(private readonly UserDeletor $userDeletor)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function deleteUser(string $id): void
    {
        $userId = UserId::fromValue($id);
        $this->userDeletor->deleteUser($userId);
    }
}
