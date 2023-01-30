<?php

namespace MoneyTransaction\Application\Controllers\User;

use MoneyTransaction\Application\Resources\User\UserResponse;
use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Services\User\UserFind;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class Find
{
    public function __construct(private readonly UserFind $userFind)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUser(string $id): UserResponse
    {
        $userId = UserId::fromValue($id);
        $user = $this->userFind->findUser($userId);

        return UserResponse::fromUser($user);
    }
}
