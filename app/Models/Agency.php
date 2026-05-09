<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    protected $table = 'agency';

    protected $primaryKey = 'id_agency';

    public $timestamps = false;

    protected $fillable = [
        'agency_name',
        'admin',
    ];

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin', 'id_user');
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'agency', 'id_agency');
    }
}