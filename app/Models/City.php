<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    // Forzamos el nombre de la tabla y la PK según tu esquema
    protected $table = 'city';
    protected $primaryKey = 'id_city';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'country', // FK id_country
    ];

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'id_country');
    }

    public function lugares(): HasMany
    {
        return $this->hasMany(PlaceAvailable::class, 'city', 'id_city');
    }
}