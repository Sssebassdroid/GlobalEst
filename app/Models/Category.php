<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class Category extends Model
{

    protected $table = 'category';

    protected $primaryKey = 'id_category';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];


    public function tours() : BelongsToMany
     {
        return $this->belongsToMany(
            Tour::class,
            'category_tour',
            'category_id',
            'tour_id');
    }

}
