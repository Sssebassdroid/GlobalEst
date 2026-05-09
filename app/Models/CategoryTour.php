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
        // Relacionamos con el modelo Tour usando la FK 'category_tour'
        return $this->hasMany(Tour::class, 'category_tour', 'id_category_tour');
    }

    public function categories(): HasMany
    {
        // Relacionamos con el modelo Tour usando la FK 'category_tour'
        return $this->hasMany(Category::class, 'category', 'id_category_tour');
    }


}