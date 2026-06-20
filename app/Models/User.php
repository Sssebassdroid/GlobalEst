<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // Importante
use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. La importación


/**
 * Modelo de usuario.
 *
 * @property int $id_user
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
    protected $primaryKey = 'id_user';
    public $timestamps = false;

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

    public function roleType()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }

    public function agencia(): HasOne
    {
        return $this->hasOne(Agency::class, 'user_id', 'id_user');
    }

    public function isBusiness()
    {
        return $this->role_id == 1;
    }

    public function isNormalUser()
    {
        return $this->role_id == 2;
    }






}
