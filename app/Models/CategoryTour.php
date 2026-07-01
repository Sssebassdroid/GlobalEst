<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tour_id
 * @property int $category_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryTour whereTourId($value)
 * @mixin Eloquent
 */
class CategoryTour extends Model
{
    use HasFactory;

    protected $table = 'category_tour';

    public $timestamps = false;

    protected $fillable = [
        'tour_id',
        'category_id',
    ];

}
