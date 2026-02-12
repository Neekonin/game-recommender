<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Style extends Model
{
    protected $fillable = [
        'rawg_id',
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($style) {
            if (empty($style->slug)) {
                $style->slug = Str::slug($style->name);
            }
        });
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_styles',
            'style_id',
            'game_id'
        );
    }
}