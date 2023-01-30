<?php

namespace MoneyTransaction\Application\Controllers\User;

use MoneyTransaction\Application\Resources\User\UserResponse;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\User\UserAlreadyExistsException;
use MoneyTransaction\Domain\Exceptions\User\UserTypeException;
use MoneyTransaction\Domain\Services\User\UserCreator;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\User\UserName;
use MoneyTransaction\Domain\ValueObjects\User\UserPassword;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;

class Create
{
    public function __construct(
        private readonly UserCreator $userCreator,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) {
    }

    /**
     * @throws UserTypeException
     * @throws UserAlreadyExistsException
     */
    public function createUser(string $name, string $email, string $cpf, string $password, string $type): UserResponse
    {
        $userId = UserId::fromValue($this->uuidGenerator->generate());
        $userName = UserName::fromValue($name);
        $userEmail = UserEmail::fromValue($email);
        $userCpf = UserCpf::fromValue($cpf);
        $userPassword = UserPassword::fromValue($password);
        $userType = UserType::fromValue($type);

        $user = $this->userCreator->createUser($userId, $userName, $userEmail, $userCpf, $userPassword, $userType);

        return UserResponse::fromUser($user);
    }
}
