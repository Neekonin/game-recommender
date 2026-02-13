<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Style extends Model
{
    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array<int, string>
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
        static::creating(function ($style) {
            if (empty($style->slug)) {
                $style->slug = Str::slug($style->name);
            }
        });
    }

    /**
     * Obtém os jogos associados a este estilo.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
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