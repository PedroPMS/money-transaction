<?php

namespace MoneyTransaction\Infrastructure\Repositories\Eloquent;

use MoneyTransaction\Domain\Entities\Transaction;
use MoneyTransaction\Domain\Enums\Transaction\TransactionStatus;
use MoneyTransaction\Domain\Exceptions\Transaction\TransactionStatusException;
use MoneyTransaction\Domain\Repositories\TransactionRepository;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;
use MoneyTransaction\Infrastructure\Models\TransactionModel;

final class TransactionEloquentRepository implements TransactionRepository
{
    public function __construct(private readonly TransactionModel $model)
    {
    }

    public function create(Transaction $transaction): void
    {
        $this->model->newQuery()->create($transaction->jsonSerialize());
    }

    /**
     * @throws TransactionStatusException
     */
    public function findById(TransactionId $id): ?Transaction
    {
        /** @var TransactionModel $transactionModel */
        $transactionModel = $this->model->newQuery()->find($id->value());

        if (! $transactionModel) {
            return null;
        }

        return $this->toDomain($transactionModel);
    }

    public function updateStatus(TransactionId $transactionId, TransactionStatus $newStatus): void
    {
        $transactionModel = $this->model->newQuery()->find($transactionId->value());
        $transactionModel->update(['status' => $newStatus->value]);
    }

    public function markAsNotified(TransactionId $transactionId, string $notifiedAt): void
    {
        $transactionModel = $this->model->newQuery()->find($transactionId->value());
        $transactionModel->update(['notified_at' => $notifiedAt]);
    }

    /**
     * @throws TransactionStatusException
     */
    private function toDomain(TransactionModel $transactionModel): Transaction
    {
        return Transaction::fromPrimitives(
            $transactionModel->id,
            $transactionModel->payer_id,
            $transactionModel->payee_id,
            $transactionModel->value,
            $transactionModel->status,
        );
    }
}
