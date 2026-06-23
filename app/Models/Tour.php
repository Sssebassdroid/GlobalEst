<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Tour
 * @method static Builder|Tour latestFeatured()
 */
class Tour extends Model
{

    protected $table = 'tour';

    public $timestamps = true;

    protected $fillable = [
        'tour_name',
        'tour_price',
        'description',
        'estimated_duration',
        'image',
        'agency_id',
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
        return $this->belongsToMany(PlaceAvailable::class)
            ->withPivot('order_position')
            ->withTimestamps();
    }
}
