<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceAvailable extends Model
{
    protected $table = 'places_available';
    protected $primaryKey = 'id_place'; // Importante para recuperar el ID tras el Create
    public $timestamps = false;

    protected $fillable = [
        'name',
        'display_name',
        'osm_id',
        'osm_type',
        'latitude',  // Corregido a inglés según tu esquema
        'longitude', // Corregido a inglés según tu esquema
        'importance',
        'city'       // FK hacia la tabla city
    ];


public function ciudad(): BelongsTo
{
    return $this->belongsTo(City::class, 'city', 'id_city');
}


}