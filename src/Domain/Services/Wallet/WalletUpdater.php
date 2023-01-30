<?php

namespace MoneyTransaction\Domain\Services\Wallet;

use MoneyTransaction\Domain\Entities\Wallet;
use MoneyTransaction\Domain\Repositories\WalletRepository;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletAmount;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletId;

class WalletUpdater
{
    public function __construct(private readonly WalletRepository $repository)
    {
    }

    public function updateWallet(WalletId $id, WalletAmount $amount, UserId $userId): Wallet
    {
        $wallet = Wallet::create($id, $amount, $userId);
        $this->repository->update($wallet);

        return $wallet;
    }
}
