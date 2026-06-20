<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Tour extends Model
{

    protected $table = 'tour';

    protected $primaryKey = 'id_tour';

    public $timestamps = true;

    protected $fillable = [
        'agency',
        'category_tour',
        'tour_price',
        'tour_name',
        'description',
        'created_at',
        'updated_at',
        'estimated_duration',
        'image',
    ];

    /**
     * Scope para obtener los últimos tours destacados.
     *
     * @param Builder<Tour> $query
     * @param int $limit
     * @return Builder<Tour>
     */
    public function scopeLatestFeatured(Builder $query, int $limit = 10): Builder
    {
        return $query->with(['categories', 'agency'])
            ->latest()
            ->take($limit);
    }

    public function agency(): BelongsTo
{
    return $this->belongsTo(
        Agency::class,
        'agency_id',
        'id_agency');
}

public function categories(): BelongsToMany
{
    return $this->belongsToMany(
        Category::class,
        'category_tour',
        'tour_id',
        'category_id');
}

}
