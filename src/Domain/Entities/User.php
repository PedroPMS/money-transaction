<?php

namespace MoneyTransaction\Domain\Entities;

use JsonSerializable;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\User\UserTypeException;
use MoneyTransaction\Domain\ValueObjects\User\UserCpf;
use MoneyTransaction\Domain\ValueObjects\User\UserEmail;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\User\UserName;
use MoneyTransaction\Domain\ValueObjects\User\UserPassword;

class User implements JsonSerializable
{
    public function __construct(
        public readonly UserId $id,
        public readonly UserName $name,
        public readonly UserEmail $email,
        public readonly UserCpf $cpf,
        public readonly UserPassword $password,
        public readonly UserType $type,
    ) {
    }

    /**
     * @throws UserTypeException
     */
    public static function fromPrimitives(string $id, string $name, string $email, string $cpf, string $password, string $type): self
    {
        return new self(
            UserId::fromValue($id),
            UserName::fromValue($name),
            UserEmail::fromValue($email),
            UserCpf::fromValue($cpf),
            UserPassword::fromValue($password),
            UserType::fromValue($type)
        );
    }

    public static function create(UserId $id, UserName $name, UserEmail $email, UserCpf $cpf, UserPassword $password, UserType $type): self
    {
        return new self($id, $name, $email, $cpf, $password, $type);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'password' => $this->password,
            'type' => $this->type,
        ];
    }

    public function isShopkeeper(): bool
    {
        return $this->type === UserType::SHOPKEEPER;
    }
}
