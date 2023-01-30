<?php

namespace MoneyTransaction\Domain\Services\User;

use MoneyTransaction\Domain\Exceptions\User\UserAlreadyExistsException;
use MoneyTransaction\Domain\Repositories\UserRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class UserAlreadyExists
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function checkUserExists(UserEmail $email, UserCpf $cpf, ?UserId $id = null): void
    {
        if ($this->repository->findByEmail($email, $id)) {
            throw UserAlreadyExistsException::emailAlreadyExists();
        }

        if ($this->repository->findByCpf($cpf, $id)) {
            throw UserAlreadyExistsException::cpfAlreadyExists();
        }
    }
}
