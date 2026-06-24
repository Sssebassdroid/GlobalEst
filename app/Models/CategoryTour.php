<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTour extends Model
{
    protected $table = 'category_tour';

    public $timestamps = false;

    protected $fillable = [
        'tour_id',
        'category_id',
    ];

}
