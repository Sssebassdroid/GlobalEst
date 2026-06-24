<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Occurrence extends Model
{

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
