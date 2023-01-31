<?php

namespace MoneyTransaction\Application\Resources\User;

use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Shared\Domain\ResponseInterface;

final class UserResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $cpf,
        public readonly string $type,
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->id->value(),
            $user->name->value(),
            $user->email->value(),
            $user->cpf->value(),
            $user->type->value,
        );
    }

    /** @return array<string, string|int> */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'type' => $this->type,
        ];
    }
}
