<?php

namespace MoneyTransaction\Domain\Services\Transaction;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Transaction\ShopkeeperCantStartTransactionException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionUnautorizedException;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;

class TransactionValidate
{
    public function __construct(
        private readonly TransactionAuthorizer $transactionAuthorizer,
        private readonly PayerHasEnoughBalanceForTransaction $hasEnoughBalanceForTransaction
    ) {
    }

    /**
     * @throws ShopkeeperCantStartTransactionException
     * @throws PayerDoesntHaveEnoughBalanceException
     * @throws WalletNotFoundException
     * @throws TransactionUnautorizedException
     */
    public function validateTransaction(User $payer, Transaction $transaction): void
    {
        if ($payer->isShopkeeper()) {
            throw new ShopkeeperCantStartTransactionException();
        }

        $this->hasEnoughBalanceForTransaction->checkPayerHasEnoughBalanceForTransaction($payer->id, $transaction->value);

        if (! $this->transactionAuthorizer->isAutorized()) {
            throw new TransactionUnautorizedException();
        }
    }
}
