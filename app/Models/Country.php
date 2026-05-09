<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    // Definimos la tabla y la PK según tu esquema
    protected $table = 'country';
    protected $primaryKey = 'id_country';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'continent', // FK que apunta a id_continent
    ];

    /**
     * Relación: Un país pertenece a un continente.
     */
    public function continente(): BelongsTo
    {
        // El segundo parámetro es la FK en esta tabla, el tercero es la PK en Continent
        return $this->belongsTo(Continent::class, 'continent', 'id_continent');
    }

    /**
     * Relación: Un país tiene muchas ciudades.
     */
    public function ciudades(): HasMany
    {
        return $this->hasMany(City::class, 'country', 'id_country');
    }
}