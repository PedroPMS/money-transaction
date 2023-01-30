<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Infrastructure\Models\TransactionModel;
use MoneyTransaction\Infrastructure\Models\UserModel;
use MoneyTransaction\Infrastructure\Models\WalletModel;

class TransactionFactory extends Factory
{
    protected $model = TransactionModel::class;

    public function definition(): array
    {
        return [
            'id' => Str::orderedUuid()->toString(),
            'payer_id' => UserModel::factory()->has(WalletModel::factory(), 'wallet'),
            'payee_id' => UserModel::factory()->has(WalletModel::factory(), 'wallet'),
            'value' => 1000,
            'status' => TransactionStatus::CREATED->value,
        ];
    }
}
