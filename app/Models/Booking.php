<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $table = 'booking';

    public $timestamps = true;

    protected $fillable = [
        'order_date',
        'total_amount',
        'user_id',
    ];

    public function user(): HasOne
    {
        return $this->HasOne(User::class);
    }

}
