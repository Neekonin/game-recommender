<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = [
        'rawg_id', 
        'name'
    ];

    /**
     * O "booted" method do modelo.
     * Gera o slug automaticamente a partir do nome se estiver vazio.
    */
    protected static function booted()
    {
        static::creating(function ($platform) {
            if (empty($platform->slug)) {
                $platform->slug = Str::slug($platform->name);
            }
        });
    }

    /**
     * Obtém os jogos disponíveis nesta plataforma.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_platforms',
            'platform_id',
            'game_id'
        );
    }
}
