<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaceAvailable extends Model
{
    protected $table = 'places_available';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'display_name',
        'osm_id',
        'osm_type',
        'latitude',
        'longitude',
        'importance',
        'city_id'
    ];


public function city(): BelongsTo
{
    return $this->belongsTo(City::class);
}


}
