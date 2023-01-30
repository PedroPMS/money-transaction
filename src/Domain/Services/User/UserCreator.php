<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\User\UserAlreadyExistsException;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\User\UserName;
use MoneyTransaction\Domain\ValueObjects\User\UserPassword;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserAlreadyExists $checkUserAlreadyExists
    ) {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function createUser(UserId $id, UserName $name, UserEmail $email, UserCpf $cpf, UserPassword $password, UserType $type): User
    {
        $this->checkUserAlreadyExists->checkUserExists($email, $cpf);

        $user = User::create($id, $name, $email, $cpf, $password, $type);
        $this->repository->create($user);

        return $user;
    }
}
