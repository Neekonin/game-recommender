<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
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
        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);

            }
        });
    }

    /**
     * Obtém os jogos disponíveis nesta loja.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_stores',
            'store_id',
            'game_id',
            'url_store'
        );
    }
}
