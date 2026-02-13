<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = [
        'rawg_id',
        'name',
        'slug',
    ];

    /**
     * O "booted" method do modelo.
     * Gera o slug automaticamente a partir do nome se estiver vazio.
    */
    protected static function booted()
    {
        static::creating(function ($genre) {
            if (empty($genre->slug)) {
                $genre->slug = Str::slug($genre->name);
            }
        });
    }

    /**
     * Obtém todos os jogos associados a este gênero.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_genres',
            'genre_id',
            'game_id'
        );
    }
}