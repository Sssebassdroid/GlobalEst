<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property string $description
 * @property string $duration
 * @property string|null $image
 * @property int $capacity
 * @property int $agency_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency $agency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Place> $places
 * @property-read int|null $places_count
 * @method static Builder<static>|Tour latestFeatured()
 * @method static Builder<static>|Tour newModelQuery()
 * @method static Builder<static>|Tour newQuery()
 * @method static Builder<static>|Tour query()
 * @method static Builder<static>|Tour whereAgencyId($value)
 * @method static Builder<static>|Tour whereCapacity($value)
 * @method static Builder<static>|Tour whereCreatedAt($value)
 * @method static Builder<static>|Tour whereDescription($value)
 * @method static Builder<static>|Tour whereDuration($value)
 * @method static Builder<static>|Tour whereId($value)
 * @method static Builder<static>|Tour whereImage($value)
 * @method static Builder<static>|Tour whereName($value)
 * @method static Builder<static>|Tour wherePrice($value)
 * @method static Builder<static>|Tour whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tour extends Model
{
    use HasFactory;


    protected $table = 'tour';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'price',
        'description',
        'duration',
        'capacity',
        'agency_id',
        'image',
    ];


    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeLatestFeatured(Builder $query): Builder
    {
        return $query->whereNotNull('agency_id');
    }


    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class)
            ->withPivot('position');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
