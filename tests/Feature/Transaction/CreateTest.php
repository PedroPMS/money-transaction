<?php

namespace Tests\Feature\Transaction;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Mockery\MockInterface;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Services\Transaction\TransactionNotifier;
use MoneyTransaction\Domain\Services\Transaction\TransactionValidate;
use MoneyTransaction\Infrastructure\Models\TransactionModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCreateANewTransaction()
    {
        $this->instance(
            TransactionValidate::class,
            Mockery::mock(TransactionValidate::class, function (MockInterface $mock) {
                $mock->shouldReceive('validateTransaction')
                    ->once()
                    ->andReturn();
            })
        );

        $this->instance(
            TransactionNotifier::class,
            Mockery::mock(TransactionNotifier::class, function (MockInterface $mock) {
                $mock->shouldReceive('sendNotification')
                    ->once()
                    ->andReturn();
            })
        );

        /** @var TransactionModel $transaction */
        $transaction = TransactionModel::factory()->make();
        $oldPayerBalance = $transaction->payer->wallet->amount;
        $oldPayeeBalance = $transaction->payee->wallet->amount;

        $response = $this->postJson(
            '/transaction',
            [
                'payer_id' => $transaction->payer_id,
                'payee_id' => $transaction->payee_id,
                'value' => $transaction->value,
            ]
        );

        $this->assertDatabaseHas(
            'wallet',
            [
                'user_id' => $transaction->payer_id,
                'amount' => $oldPayerBalance - $transaction->value,
            ]
        );

        $this->assertDatabaseHas(
            'wallet',
            [
                'user_id' => $transaction->payee_id,
                'amount' => $oldPayeeBalance + $transaction->value,
            ]
        );

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $transaction->payer_id,
                'payee_id' => $transaction->payee_id,
                'value' => $transaction->value,
                'status' => TransactionStatus::SUCCEEDED->value,
            ],
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
