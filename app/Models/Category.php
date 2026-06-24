<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Category extends Model
{

    protected $table = 'category';
    const ?string UPDATED_AT = null;

    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class);
    }
}
