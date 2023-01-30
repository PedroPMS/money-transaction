<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\User\UserAlreadyExistsException;
use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\User\UserName;

class UserUpdater
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFind $userFind,
        private readonly UserAlreadyExists $checkUserAlreadyExists
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     * @throws UserNotFoundException
     */
    public function updateUser(UserId $id, UserName $name, UserEmail $email, UserCpf $cpf, UserType $type): User
    {
        $user = $this->userFind->findUser($id);
        $this->checkUserAlreadyExists->checkUserExists($email, $cpf, $id);

        $user = User::create($id, $name, $email, $cpf, $user->password, $type);
        $this->repository->update($user);

        return $user;
    }
}
