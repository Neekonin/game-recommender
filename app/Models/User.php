<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function preference(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'user_genre',
            'user_id',
            'genre_id'
        )->withPivot('weight');
    }

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(
            Style::class,
            'user_game_style',
            'user_id',
            'game_style_id'
        )->withPivot('weight');
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(
            Platform::class,
            'user_platform',
            'user_id',
            'platform_id'
        );
    }

    public function favoriteGames(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'favorite_games',
            'user_id',
            'game_id'
        );
    }
}
