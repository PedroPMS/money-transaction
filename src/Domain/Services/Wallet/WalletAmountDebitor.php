<?php

namespace MoneyTransaction\Domain\Services\Wallet;

use MoneyTransaction\Domain\Entities\Wallet;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Repositories\WalletRepository;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletAmount;

class WalletAmountDebitor
{
    public function __construct(
        private readonly WalletRepository $repository,
        private readonly WalletFind $walletFinder,
    ) {
    }

    /**
     * @throws WalletNotFoundException
     */
    public function debitWalletAmount(UserId $userId, TransactionValue $value): Wallet
    {
        $wallet = $this->walletFinder->findWalletByUser($userId);

        $newWalletAmount = WalletAmount::fromValue($wallet->amount->value() - $value->value());
        $newWalletBalance = Wallet::create($wallet->id, $newWalletAmount, $userId);
        $this->repository->update($newWalletBalance);

        return $wallet;
    }
}
