<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $address_type
 * @property numeric $lat
 * @property numeric $lon
 * @property string $osm_id
 * @property string $osm_type
 * @property string|null $state
 * @property numeric|null $importance
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tour> $tours
 * @property-read int|null $tours_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereAddressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereImportance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereOsmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereOsmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Place extends Model
{
    use HasFactory;

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
