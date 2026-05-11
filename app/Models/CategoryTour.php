<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importación necesaria

class CategoryTour extends Model
{
    protected $table = 'category_tour';
    protected $primaryKey = 'id_category_tour';
    public $timestamps = false;

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'tour', 'id_tour');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'category', 'id_category');
    }


}