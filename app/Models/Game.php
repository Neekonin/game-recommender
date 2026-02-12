<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'released_at' => 'date',
        'rating'      => 'float',
        'metacritic'  => 'integer',
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
        return $this->belongsToMany(Genre::class, 'game_genres');
    }

    public function platforms() {
        return $this->belongsToMany(Platform::class, 'game_platforms');
    }

    public function styles() {
        return $this->belongsToMany(Style::class, 'game_styles');
    }

    public function stores() {
        return $this->belongsToMany(Store::class, 'game_stores')
        ->withPivot('url_store');
    }

    public function screenshots() {
        return $this->hasMany(Screenshot::class, 'game_id');
    }

    public function trailers()
    {
        return $this->hasOne(Trailer::class, 'game_id');
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorite_games');
    }

}
