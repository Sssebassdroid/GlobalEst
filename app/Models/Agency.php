<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tour> $tours
 * @property-read int|null $tours_count
 * @method static Builder<static>|Agency newModelQuery()
 * @method static Builder<static>|Agency newQuery()
 * @method static Builder<static>|Agency query()
 * @method static Builder<static>|Agency whereCreatedAt($value)
 * @method static Builder<static>|Agency whereId($value)
 * @method static Builder<static>|Agency whereName($value)
 * @method static Builder<static>|Agency whereUpdatedAt($value)
 * @method static Builder<static>|Agency whereUserId($value)
 * @mixin \Eloquent
 */
class Agency extends Model
{
    use HasFactory;

    protected $table = 'agency';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'user_id',
    ];


    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
