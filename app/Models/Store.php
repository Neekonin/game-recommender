<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    protected $fillable = [
        'rawg_id',
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);

            }
        });
    }

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
