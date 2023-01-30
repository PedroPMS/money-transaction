<?php

namespace MoneyTransaction\Domain\Services\Wallet;

use MoneyTransaction\Domain\Entities\Wallet;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Repositories\WalletRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class WalletFind
{
    public function __construct(private readonly WalletRepository $repository)
    {
    }

    /**
     * @throws WalletNotFoundException
     */
    public function findWalletByUser(UserId $userId): Wallet
    {
        $wallet = $this->repository->findByUserId($userId);

        if (! $wallet) {
            throw new WalletNotFoundException();
        }

        return $wallet;
    }
}
