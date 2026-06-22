<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Agency extends Model
    {
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
