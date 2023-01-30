<?php

namespace MoneyTransaction\Infrastructure\Models;

use Database\Factories\WalletFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property int $amount
 * @property string $user_id
 */
class WalletModel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'wallet';

    protected $fillable = ['id', 'amount', 'user_id', 'created_at', 'updated_at'];

    protected static function newFactory(): WalletFactory
    {
        return WalletFactory::new();
    }
}
