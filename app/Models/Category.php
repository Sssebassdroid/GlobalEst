<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{

    protected $table = 'category';


    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function tours(): BelongsToMany
    {
        return $this->BelongToMany(Tour::class);
    }
}
