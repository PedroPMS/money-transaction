<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use Exception;
use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;
use MoneyTransaction\Domain\Services\Transaction\TransactionUpdater;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountCreditor;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountDebitor;
use MoneyTransaction\Shared\Domain\DbTransactionInterface;

class Transfer
{
    public function __construct(
        private readonly NotifyTransaction $notifier,
        private readonly WalletAmountDebitor $walletDebitor,
        private readonly WalletAmountCreditor $walletCreditor,
        private readonly DbTransactionInterface $dbTransaction,
        private readonly TransactionUpdater $transactionUpdater,
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
            $this->transactionUpdater->updateTransactionStatus($transaction->id, TransactionStatus::SUCCEEDED);
            $this->dbTransaction->commit();
        } catch (Exception $exception) {
            $this->dbTransaction->rollBack();
            throw $exception;
        }

        $this->notifier->dispatchTransactionNotification($transaction->id);
    }
}
