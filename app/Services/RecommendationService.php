<?php

namespace App\Services;

use App\Models\User;
use App\Models\Game;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function recommend(array $filters)
    {
        return Game::query()
            ->when($filters['genres'] ?? null, fn ($q, $genres) =>
                $q->whereHas('genres', fn ($g) =>
                    $g->whereIn('slug', $genres)
                )
            )
            ->when($filters['platforms'] ?? null, fn ($q, $platforms) =>
                $q->whereHas('platforms', fn ($p) =>
                    $p->whereIn('slug', $platforms)
                )
            )
            ->when($filters['tags'] ?? null, fn ($q, $tags) =>
                $q->whereHas('Styles', fn ($t) =>
                    $t->whereIn('slug', $tags)
                )
            )
            ->when($filters['min_rating'] ?? null, fn ($q, $r) =>
                $q->where('rating', '>=', $r)
            )
            ->when($filters['min_metacritic'] ?? null, fn ($q, $m) =>
                $q->where('metacritic', '>=', $m)
            )
            ->with(['genres', 'platforms'])
            ->limit(20)
            ->get();
    }
}
