<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screenshot extends Model
{
    /**
     * A tabela associada ao modelo.
     * @var string
    */
    protected $table = 'game_screenshots';

    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
    */
    protected $fillable = ['game_id', 'image'];

    /**
     * Obtém o jogo ao qual esta screenshot pertence.
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
