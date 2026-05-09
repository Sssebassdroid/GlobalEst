<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // Importante

class User extends Authenticatable
{
    use Notifiable;

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
        'role',
    ];

    protected $hidden = ['password'];

    public function roleType()
    {
        return $this->belongsTo(Role::class, 'role', 'id_role');
    }

    public function agencia(): HasOne
    {
        return $this->hasOne(Agency::class, 'admin', 'id_user');
    }

    public function isBusiness()
    {
        return $this->role === 1;
    }

    public function isNormalUser()
    {
        return $this->role === 2;
    }






}