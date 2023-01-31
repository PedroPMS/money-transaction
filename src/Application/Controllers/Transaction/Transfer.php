<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use Exception;
use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountCreditor;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountDebitor;
use MoneyTransaction\Shared\Domain\DbTransactionInterface;

class Transfer
{
    public function __construct(
        private readonly WalletAmountDebitor $walletDebitor,
        private readonly WalletAmountCreditor $walletCreditor,
        private readonly DbTransactionInterface $dbTransaction,
    ) {
    }

    /**
     * @throws WalletNotFoundException
     * @throws Exception
     */
    public function transferFunds(Transaction $transaction): void
    {
        $this->dbTransaction->beginTransaction();

        try {
            $this->walletDebitor->debitWalletAmount($transaction->payerId, $transaction->value);
            $this->walletCreditor->creditWalletAmount($transaction->payeeId, $transaction->value);
            $this->dbTransaction->commit();
        } catch (Exception $exception) {
            $this->dbTransaction->rollBack();
            throw $exception;
        }

        // todo send email
    }
}
