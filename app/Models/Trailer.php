<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trailer extends Model
{
    protected $table = 'game_trailers';

    protected $fillable = [
        'game_id',
        'name',
        'url'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(
            Game::class,
            'game_id'
        );
    }
}
