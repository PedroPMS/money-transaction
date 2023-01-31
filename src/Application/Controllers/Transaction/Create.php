<?php

namespace MoneyTransaction\Application\Controllers\Transaction;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Transaction\ShopkeeperCantStartTransactionException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionUnautorizedException;
use MoneyTransaction\Domain\Exceptions\User\UserNotFoundException;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Services\Transaction\NotifyTransaction;
use MoneyTransaction\Domain\Services\Transaction\TransactionCreator;
use MoneyTransaction\Domain\Services\Transaction\TransactionUpdater;
use MoneyTransaction\Domain\Services\Transaction\TransactionValidate;
use MoneyTransaction\Domain\Services\User\UserFind;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Shared\Domain\UuidGeneratorInterface;

class Create
{
    public function __construct(
        private readonly Transfer $transfer,
        private readonly UserFind $userFinder,
        private readonly NotifyTransaction $notifier,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly TransactionCreator $transactionCreator,
        private readonly TransactionValidate $transactionValidator,
        private readonly TransactionUpdater $transactionUpdater,
    ) {
    }

    /**
     * @throws UserNotFoundException
     * @throws WalletNotFoundException
     */
    public function createTransaction(string $payerId, string $payeeId, int $value): void
    {
        $transaction = $this->persistTransaction($payerId, $payeeId, $value);
        $payer = $this->userFinder->findUser(UserId::fromValue($transaction->payerId));

        try {
            $this->transactionValidator->validateTransaction($payer, $transaction);
            $this->transfer->transferFunds($transaction);
            $this->transactionUpdater->updateTransactionStatus($transaction->id, TransactionStatus::SUCCEEDED);
        } catch (PayerDoesntHaveEnoughBalanceException|ShopkeeperCantStartTransactionException|TransactionUnautorizedException $exception) {
            $this->transactionUpdater->updateTransactionStatus($transaction->id, TransactionStatus::REJECTED);
            $this->notifier->dispatchTransactionNotification();
        }
    }

    private function persistTransaction(string $payerId, string $payeeId, int $value): Transaction
    {
        $id = TransactionId::fromValue($this->uuidGenerator->generate());
        $payerId = UserId::fromValue($payerId);
        $payeeId = UserId::fromValue($payeeId);
        $value = TransactionValue::fromValue($value);
        $status = TransactionStatus::CREATED;

        return $this->transactionCreator->createTransaction($id, $payerId, $payeeId, $value, $status);
    }
}
