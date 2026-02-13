<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = [
        'rawg_id',
        'name',
        'released_at',
        'rating',
        'metacritic',
        'cover_image',
        'description',
    ];

    /**
     * Conversão de tipos de atributos.
     * @var array
    */
    protected $casts = [
        'released_at' => 'date',
        'rating'      => 'float',
        'metacritic'  => 'integer',
    ];

    /**
     * O "booted" method do modelo.
     * Gera o slug automaticamente a partir do nome se estiver vazio.
    */
    protected static function booted()
    {
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->name);
            }
        });
    }

    /**
     * Gêneros associados ao jogo.
    */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'game_genres');
    }

    /**
     * Plataformas onde o jogo está disponível.
    */
    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'game_platforms');
    }

    /**
     * Estilos/Categorias do jogo.
    */
    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class, 'game_styles');
    }

    /**
     * Lojas que vendem o jogo, incluindo a URL customizada.
    */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'game_stores')
            ->withPivot('url_store');
    }

    /**
     * Screenshots capturadas do jogo.
    */
    public function screenshots(): HasMany
    {
        return $this->hasMany(Screenshot::class, 'game_id');
    }

    /**
     * Trailer principal do jogo.
    */
    public function trailers(): HasOne
    {
        return $this->hasOne(Trailer::class, 'game_id');
    }

    /**
     * Usuários que favoritaram este jogo.
    */
    public function favorite(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_games');
    }
}