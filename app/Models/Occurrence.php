<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    protected $table = 'occurrences';
    protected $fillable = [
        'tour_id',
        'tour_code',
        'tour_name',
    ];

}
