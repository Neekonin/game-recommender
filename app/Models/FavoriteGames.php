<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteGames extends Model
{
    /**
     * A tabela associada ao modelo.
     * @var string
    */
    protected $table = 'favorite_games';

    /**
     * Os atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = [
        'user_id',
        'game_id',
    ];

    /**
     * Obtém o usuário proprietário do favorito.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {   
        return $this->belongsTo(User::class);
    }

    /**
     * Obtém o jogo que foi favoritado.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function game(): BelongsTo 
    {
        return $this->belongsTo(Game::class);
    }
}