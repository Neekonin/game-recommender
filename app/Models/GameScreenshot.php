<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GameScreenshot extends Model
{
    
    protected static function booted()
    {
        static::creating(function ($genre) {
            if (empty($genre->slug)) {
                $genre->slug = Str::slug($genre->name);
            }
        });
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_genre',
            'genre_id',
            'game_id'
        );
    }
}
