<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $quantity
 * @property numeric $subtotal
 * @property int $booking_id
 * @property int $occurrence_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Booking|null $booking
 * @property-read \App\Models\Occurrence|null $occurrence
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereOccurrenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereSubtotal($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    public $timestamps = true;
    const ?string UPDATED_AT = null;

    protected $fillable = [
        'quantity',
        'subtotal',
        'booking_id',
        'occurrence_id',
    ];


    public function booking(): belongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function occurrence(): BelongsTo
    {
        return $this->belongsTo(Occurrence::class);
    }
}
