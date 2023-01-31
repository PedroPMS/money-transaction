<?php

namespace Tests\Feature\Transaction;

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use MoneyTransaction\Application\Controllers\Transaction\Transfer;
use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Entities\Wallet;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionStatusException;
use MoneyTransaction\Domain\Exceptions\User\UserTypeException;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountCreditor;
use MoneyTransaction\Domain\Services\Wallet\WalletAmountDebitor;
use MoneyTransaction\Infrastructure\Models\TransactionModel;
use MoneyTransaction\Shared\Domain\DbTransactionInterface;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @throws UserTypeException
     * @throws TransactionStatusException
     */
    public function testItCommitATransfer()
    {
        Queue::fake();

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory()->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $payerWallet = Wallet::fromPrimitives(
            $transactionModel->payer->wallet->id,
            $transactionModel->payer->wallet->amount,
            $transactionModel->payer->wallet->user_id,
        );

        $payeeWallet = Wallet::fromPrimitives(
            $transactionModel->payee->wallet->id,
            $transactionModel->payee->wallet->amount,
            $transactionModel->payee->wallet->user_id,
        );

        $this->instance(
            WalletAmountDebitor::class,
            Mockery::mock(WalletAmountDebitor::class, function (MockInterface $mock) use ($payerWallet) {
                $mock->shouldReceive('debitWalletAmount')
                    ->once()
                    ->andReturn($payerWallet);
            })
        );

        $this->instance(
            WalletAmountCreditor::class,
            Mockery::mock(WalletAmountCreditor::class, function (MockInterface $mock) use ($payeeWallet) {
                $mock->shouldReceive('creditWalletAmount')
                    ->once()
                    ->andReturn($payeeWallet);
            })
        );

        $this->instance(
            DbTransactionInterface::class,
            Mockery::mock(DbTransactionInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('commit')
                    ->once()
                    ->andReturn();

                $mock->shouldReceive('beginTransaction')
                    ->once()
                    ->andReturn();
            })
        );

        $service = app(Transfer::class);
        $service->transferFunds($transaction);

        $this->assertTrue(true);
    }

    /**
     * @throws UserTypeException
     * @throws TransactionStatusException
     */
    public function testItRollbackATransfer()
    {
        Queue::fake();

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory()->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $payerWallet = Wallet::fromPrimitives(
            $transactionModel->payer->wallet->id,
            $transactionModel->payer->wallet->amount,
            $transactionModel->payer->wallet->user_id,
        );

        $this->instance(
            WalletAmountDebitor::class,
            Mockery::mock(WalletAmountDebitor::class, function (MockInterface $mock) use ($payerWallet) {
                $mock->shouldReceive('debitWalletAmount')
                    ->once()
                    ->andReturn($payerWallet);
            })
        );

        $this->instance(
            WalletAmountCreditor::class,
            Mockery::mock(WalletAmountCreditor::class, function (MockInterface $mock) {
                $mock->shouldReceive('creditWalletAmount')
                    ->once()
                    ->andThrows(Exception::class);
            })
        );

        $this->instance(
            DbTransactionInterface::class,
            Mockery::mock(DbTransactionInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('rollback')
                    ->once()
                    ->andReturn();

                $mock->shouldReceive('beginTransaction')
                    ->once()
                    ->andReturn();
            })
        );

        $this->expectException(Exception::class);

        $service = app(Transfer::class);
        $service->transferFunds($transaction);

        $this->assertTrue(true);
    }
}
