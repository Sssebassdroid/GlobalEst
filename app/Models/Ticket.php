<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
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
