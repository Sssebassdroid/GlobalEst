<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo de usuario.
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $first_last_name
 * @property string|null $second_last_name
 * @property string $email
 * @property string $password
 * @property int $role_id
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'user';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'name',
        'first_last_name',
        'second_last_name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = ['password'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function agency(): HasOne
    {
        return $this->hasOne(Agency::class);
    }

    public function isAgency(): bool
    {
        return $this->role_id == 1;
    }

    public function isTourist(): bool
    {
        return $this->role_id == 2;
    }

}
