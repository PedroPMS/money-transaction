<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MoneyTransaction\Infrastructure\Models\UserModel;
use MoneyTransaction\Infrastructure\Models\WalletModel;

class WalletFactory extends Factory
{
    protected $model = WalletModel::class;

    public function definition(): array
    {
        return [
            'id' => Str::orderedUuid()->toString(),
            'user_id' => UserModel::factory(),
            'amount' => 100000,
        ];
    }
}
