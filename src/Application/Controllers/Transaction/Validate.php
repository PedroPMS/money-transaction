<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Transaction\ShopkeeperCantStartTransactionException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionUnautorizedException;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;
use MoneyTransaction\Domain\Services\Transaction\TransactionUpdater;
use MoneyTransaction\Domain\Services\Transaction\TransactionValidate;
use MoneyTransaction\Domain\Services\User\UserFind;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class Validate
{
    public function __construct(
        private readonly NotifyTransaction $notifier,
        private readonly UserFind $userFinder,
        private readonly TransactionValidate $transactionValidator,
        private readonly TransactionUpdater $transactionUpdater,
    ) {
    }

    public function validateTransaction(UserId $payerId, Transaction $transaction): void
    {
        $payer = $this->userFinder->findUser($payerId);

        try {
            $this->transactionValidator->validateTransaction($payer, $transaction);
        } catch (PayerDoesntHaveEnoughBalanceException|ShopkeeperCantStartTransactionException|TransactionUnautorizedException $exception) {
            $this->transactionUpdater->updateTransactionStatus($transaction->id, TransactionStatus::REJECTED);
            $this->notifier->dispatchTransactionNotification($transaction->id);
            throw $exception;
        }
    }
}
