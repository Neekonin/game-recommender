<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    protected $fillable = [
        'rawg_id', 
        'name'
    ];

    protected static function booted()
    {
        static::creating(function ($platform) {
            if (empty($platform->slug)) {
                $platform->slug = Str::slug($platform->name);
            }
        });
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_platform',
            'platform_id',
            'game_id'
        );
    }
}
