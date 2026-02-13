<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trailer extends Model
{
    /**
     * A tabela associada ao modelo.
     * @var string
    */
    protected $table = 'game_trailers';

    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = [
        'game_id',
        'name',
        'url'
    ];

    /**
     * Obtém o jogo proprietário deste trailer.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function game(): BelongsTo
    {
        return $this->belongsTo(
            Game::class,
            'game_id'
        );
    }
}
