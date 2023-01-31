<?php

namespace MoneyTransaction\Domain\Services\Transaction;

use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Wallet\WalletNotFoundException;
use MoneyTransaction\Domain\Services\Wallet\WalletFind;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionValue;
use MoneyTransaction\Domain\ValueObjects\User\UserId;

class PayerHasEnoughBalanceForTransaction
{
    public function __construct(private readonly WalletFind $walletFinder)
    {
    }

    /**
     * @throws WalletNotFoundException
     * @throws PayerDoesntHaveEnoughBalanceException
     */
    public function checkPayerHasEnoughBalanceForTransaction(UserId $payerId, TransactionValue $transactionValue): void
    {
        $wallet = $this->walletFinder->findWalletByUser($payerId);

        if ($wallet->amount->value() < $transactionValue->value()) {
            throw PayerDoesntHaveEnoughBalanceException::payerDoesntHaveEnoughBalance();
        }
    }
}
