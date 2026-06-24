<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Place extends Model
{
    protected $table = 'place';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'display_name',
        'lat',
        'lon',
        'osm_id',
        'osm_type',
        'state',
        'importance',
        'city_id'
    ];


    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
