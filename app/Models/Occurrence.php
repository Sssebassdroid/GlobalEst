<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property int $capacity
 * @property int $tour_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tour $tour
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Occurrence whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Occurrence extends Model
{
    use HasFactory;

    protected $table = 'occurrence';

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'capacity',
        'tour_id',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

}
