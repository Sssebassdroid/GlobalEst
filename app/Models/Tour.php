<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tour extends Model
{

    protected $table = 'tour';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'price',
        'description',
        'duration',
        'image',
        'capacity',
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
        return $this->belongsToMany(Place::class)
            ->withPivot('position');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
