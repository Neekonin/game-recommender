<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    protected $fillable = [
        'rawg_id',
        'name',
        'released_at',
        'rating',
        'metacritic',
        'cover_image',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->name);
            }
        });
    }

    public function genres() {
        return $this->belongsToMany(Genre::class);
    }

    public function platforms() {
        return $this->belongsToMany(Platform::class);
    }

    public function stores() {
        return $this->belongsToMany(Store::class);
    }

    public function screenshots() {
        return $this->hasMany(GameScreenshot::class);
    }
}
