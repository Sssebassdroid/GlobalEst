<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


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

}
