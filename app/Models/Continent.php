<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Continent extends Model
{
    protected $table = 'continent';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function countries(): HasMany
    {
        return $this->HasMany(Country::class);
    }

}
