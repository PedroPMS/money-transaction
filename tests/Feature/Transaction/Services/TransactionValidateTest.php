<?php

namespace Tests\Feature\Transaction\Services;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Mockery\MockInterface;
use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Entities\User;
use MoneyTransaction\Domain\Enums\User\UserType;
use MoneyTransaction\Domain\Exceptions\Transaction\PayerDoesntHaveEnoughBalanceException;
use MoneyTransaction\Domain\Exceptions\Transaction\ShopkeeperCantStartTransactionException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionStatusException;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionUnautorizedException;
use MoneyTransaction\Domain\Exceptions\User\UserTypeException;
use MoneyTransaction\Domain\Services\Transaction\TransactionAuthorizer;
use MoneyTransaction\Domain\Services\Transaction\TransactionValidate;
use MoneyTransaction\Infrastructure\Models\TransactionModel;
use Tests\TestCase;

class TransactionValidateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @throws UserTypeException
     * @throws TransactionStatusException
     */
    public function testItValidadeATransaction()
    {
        $this->instance(
            TransactionAuthorizer::class,
            Mockery::mock(TransactionAuthorizer::class, function (MockInterface $mock) {
                $mock->shouldReceive('isAutorized')
                    ->once()
                    ->andReturn(true);
            })
        );

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory()->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $user = User::fromPrimitives(
            $transactionModel->payer->id,
            $transactionModel->payer->name,
            $transactionModel->payer->email,
            $transactionModel->payer->cpf,
            $transactionModel->payer->password,
            UserType::COMMON->value
        );

        $service = app(TransactionValidate::class);
        $service->validateTransaction($user, $transaction);

        $this->assertTrue(true);
    }

    /**
     * @throws TransactionStatusException
     * @throws UserTypeException
     */
    public function testItValidadeAShopkeeperUser()
    {
        $this->instance(
            TransactionAuthorizer::class, Mockery::mock(TransactionAuthorizer::class)
        );

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory(['value' => 1000000])->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $user = User::fromPrimitives(
            $transactionModel->payer->id,
            $transactionModel->payer->name,
            $transactionModel->payer->email,
            $transactionModel->payer->cpf,
            $transactionModel->payer->password,
            UserType::SHOPKEEPER->value
        );

        $this->expectException(ShopkeeperCantStartTransactionException::class);

        $service = app(TransactionValidate::class);
        $service->validateTransaction($user, $transaction);
    }

    /**
     * @throws UserTypeException
     * @throws TransactionStatusException
     */
    public function testItValidadeAUserWithoutEnoughFunds()
    {
        $this->instance(
            TransactionAuthorizer::class, Mockery::mock(TransactionAuthorizer::class)
        );

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory(['value' => 1000000])->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $user = User::fromPrimitives(
            $transactionModel->payer->id,
            $transactionModel->payer->name,
            $transactionModel->payer->email,
            $transactionModel->payer->cpf,
            $transactionModel->payer->password,
            UserType::COMMON->value
        );

        $this->expectException(PayerDoesntHaveEnoughBalanceException::class);

        $service = app(TransactionValidate::class);
        $service->validateTransaction($user, $transaction);
    }

    /**
     * @throws UserTypeException
     * @throws TransactionStatusException
     */
    public function testItValidadeUnautorizedTransaction()
    {
        $this->instance(
            TransactionAuthorizer::class,
            Mockery::mock(TransactionAuthorizer::class, function (MockInterface $mock) {
                $mock->shouldReceive('isAutorized')
                    ->once()
                    ->andReturn(false);
            })
        );

        /** @var TransactionModel $transactionModel */
        $transactionModel = TransactionModel::factory()->create();
        $transaction = Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );

        $user = User::fromPrimitives(
            $transactionModel->payer->id,
            $transactionModel->payer->name,
            $transactionModel->payer->email,
            $transactionModel->payer->cpf,
            $transactionModel->payer->password,
            UserType::COMMON->value
        );

        $this->expectException(TransactionUnautorizedException::class);

        $service = app(TransactionValidate::class);
        $service->validateTransaction($user, $transaction);
    }
}
