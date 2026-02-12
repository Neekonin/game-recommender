<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screenshot extends Model
{
    protected $table = 'game_screenshots';

    protected $fillable = ['game_id', 'image'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(
            Game::class,
            'game_id'
        );
    }
}
