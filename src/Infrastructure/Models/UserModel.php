<?php

namespace MoneyTransaction\Infrastructure\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $cpf
 * @property string $password
 * @property string $type
 */
class UserModel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'users';

    protected $fillable = ['id', 'name', 'email', 'cpf', 'password', 'type', 'created_at', 'updated_at'];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
