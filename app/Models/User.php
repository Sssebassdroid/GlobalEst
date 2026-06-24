<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'user';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'name',
        'last_name',
        'second_last_name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

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
