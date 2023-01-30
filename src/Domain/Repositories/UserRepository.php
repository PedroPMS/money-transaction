<?php

namespace MoneyTransaction\Domain\Repositories;

use MoneyTransaction\Domain\Collections\User\Users;
use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

interface UserRepository
{
    public function getAll(): Users;

    public function findById(UserId $id): ?User;

    public function findByEmail(UserEmail $email, ?UserId $excludeId = null): ?User;

    public function findByCpf(UserCpf $cpf, ?UserId $excludeId = null): ?User;

    public function create(User $user): void;

    public function delete(UserId $id): void;

    public function update(User $user): void;
}
