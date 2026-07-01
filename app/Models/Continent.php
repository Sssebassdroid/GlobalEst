<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Country> $countries
 * @property-read int|null $countries_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Continent whereName($value)
 * @mixin \Eloquent
 */
class Continent extends Model
{
    use HasFactory;

    protected $table = 'continent';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

}
