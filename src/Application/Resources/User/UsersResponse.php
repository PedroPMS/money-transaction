<?php

namespace MoneyTransaction\Application\Resources\User;

use MoneyTransaction\Domain\Collections\User\Users;
use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Shared\Domain\ResponseInterface;

final class UsersResponse implements ResponseInterface
{
    /**
     * @param  array<UserResponse>  $users
     */
    public function __construct(private readonly array $users)
    {
    }

    public static function fromUsers(Users $users): self
    {
        $userResponses = array_map(
            function (User $user) {
                return UserResponse::fromUser($user);
            },
            $users->all()
        );

        return new self($userResponses);
    }

    public function jsonSerialize(): array
    {
        return array_map(function (UserResponse $userResponse) {
            return $userResponse->jsonSerialize();
        }, $this->users);
    }
}
