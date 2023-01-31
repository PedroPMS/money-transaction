<?php

namespace MoneyTransaction\Infrastructure\Models;

use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $payer_id
 * @property string $payee_id
 * @property int $value
 * @property string $status
 * @property string $notified_at
 * @property UserModel $payer
 * @property UserModel $payee
 */
class TransactionModel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = ['id', 'payer_id', 'payee_id', 'value', 'status', 'notified_at', 'created_at', 'updated_at'];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'payer_id', 'id');
    }

    public function payee(): HasOne
    {
        return $this->hasOne(UserModel::class, 'id', 'payee_id');
    }

    protected static function newFactory(): TransactionFactory
    {
        return TransactionFactory::new();
    }
}
