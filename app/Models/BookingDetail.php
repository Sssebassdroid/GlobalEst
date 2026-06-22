<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookingDetail extends Model
{
    protected $table = 'booking_detail';

    public $timestamps = true;

    protected $fillable = [
        'quantity',
        'subtotal',
        'booking_id',
        'occurrence_id',
    ];

    public function bookings(): HasMany
    {
        return $this->HasMany(Booking::class, 'booking_id');
    }

    public function occurrence(): HasOne
    {
        return $this->hasOne(Occurrence::class);
    }
}
