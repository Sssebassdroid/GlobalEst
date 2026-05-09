<?php

namespace App\Models;
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
        'estimated_duration', //se guardaran en horas
        'image',
    ];

public function agencia(): BelongsTo
{
    return $this->belongsTo(Agency::class, 'agency', 'id_agency');
}

    public function categorias()
    {
        return $this->belongsToMany(Category::class, 'category_tour', 'tour', 'category');
    }

}