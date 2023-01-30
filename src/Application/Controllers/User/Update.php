<?php

namespace MoneyTransaction\Application\Controllers\User;

use MoneyTransaction\Application\Resources\User\UserResponse;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\User\UserAlreadyExistsException;
use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Exceptions\User\UserTypeException;
use MoneyTransaction\Domain\Services\User\UserUpdater;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\User\UserName;

class Update
{
    public function __construct(private readonly UserUpdater $userUpdater)
    {
    }

    /**
     * @throws UserTypeException
     * @throws UserAlreadyExistsException
     * @throws UserNotFoundException
     */
    public function updateUser(string $id, string $name, string $email, string $cpf, string $type): UserResponse
    {
        $userId = UserId::fromValue($id);
        $userName = UserName::fromValue($name);
        $userEmail = UserEmail::fromValue($email);
        $userCpf = UserCpf::fromValue($cpf);
        $userType = UserType::fromValue($type);

        $user = $this->userUpdater->updateUser($userId, $userName, $userEmail, $userCpf, $userType);

        return UserResponse::fromUser($user);
    }
}
