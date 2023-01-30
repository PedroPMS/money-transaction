<?php

namespace MoneyTransaction\Application\Controllers\Wallet;

use MoneyTransaction\Domain\Services\Wallet\WalletCreator;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletAmount;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletId;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;

class Create
{
    public function __construct(
        private readonly WalletCreator $walletCreator,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) {
    }

    public function createWallet(UserId $userId): void
    {
        $walletId = WalletId::fromValue($this->uuidGenerator->generate());
        $walletAmount = WalletAmount::fromValue(0);

        $this->walletCreator->createWallet($walletId, $walletAmount, $userId);
    }
}
