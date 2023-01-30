<?php

namespace MoneyTransaction\Domain\Repositories;

use MoneyTransaction\Domain\Entities\Wallet;
use MoneyTransaction\Domain\ValueObjects\User\UserId;
use MoneyTransaction\Domain\ValueObjects\Wallet\WalletId;

interface WalletRepository
{
    public function findById(WalletId $id): ?Wallet;

    public function findByUserId(UserId $userId): ?Wallet;

    public function create(Wallet $wallet): void;

    public function update(Wallet $wallet): void;
}
