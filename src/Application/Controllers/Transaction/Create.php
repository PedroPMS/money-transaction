<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Transaction\ShopkeeperCantStartTransactionException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionUnautorizedException;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class Create
{
    public function __construct(
        private readonly Transfer $transfer,
        private readonly Persist $persist,
        private readonly Validate $validate,
    ) {
    }

    /**
     * @throws PayerDoesntHaveEnoughBalanceException
     * @throws ShopkeeperCantStartTransactionException
     * @throws TransactionUnautorizedException
     * @throws WalletNotFoundException
     */
    public function createTransaction(string $payerId, string $payeeId, int $value): void
    {
        $transaction = $this->persist->persistTransaction($payerId, $payeeId, $value);

        $this->validate->validateTransaction(UserId::fromValue($payerId), $transaction);
        $this->transfer->transferFunds($transaction);
    }
}
