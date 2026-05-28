<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory; // ¡Vital para que funcionen los tests!

    protected $table = 'city';
    protected $primaryKey = 'id_city';
    
    // Si tus migraciones tienen $table->timestamps(), pon esto a true
    public $timestamps = true; 

    protected $fillable = [
        'name',
        'country_id', // Cambiado de 'country' a 'country_id' para ser precisos
    ];

    /**
     * Lógica de resolución geográfica (Mantenemos el controlador limpio)
     */
    public static function resolveUbication(array $punto): int
    {
        // 1. Resolvemos Continente
        $continent = Continent::firstOrCreate(['name' => 'Europa']);

        // 2. Resolvemos País
        $countryName = $punto['country_name'] ?? 'País Desconocido';
        $country = Country::firstOrCreate(
            ['name' => $countryName],
            ['continent_id' => $continent->id_continent]
        );

        // 3. Resolvemos Ciudad
        $cityName = $punto['city_name'] ?? 'Ciudad Desconocida';
        $city = self::firstOrCreate(
            ['name' => $cityName],
            ['country_id' => $country->id_country]
        );

        return $city->id_city;
    }

    public function pais(): BelongsTo
    {
        // Asegúrate de usar 'country_id' como FK
        return $this->belongsTo(Country::class, 'country_id', 'id_country');
    }

    public function lugares(): HasMany
    {
        return $this->hasMany(PlaceAvailable::class, 'city_id', 'id_city');
    }
}