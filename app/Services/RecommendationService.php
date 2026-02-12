<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function getRecommendation(array $filters): Collection
    {
        return Game::query()            
            ->when($filters['genres'] ?? null, function ($q, $genres) {
                foreach ($genres as $genre) {
                    $q->whereHas('genres', fn ($g) => $g->where('slug', $genre));
                }
            })
            ->when($filters['platforms'] ?? null, function ($q, $platforms) {
                foreach ($platforms as $platform) {
                    $q->whereHas('platforms', fn ($p) => $p->where('slug', $platform));
                }
            })
            ->when($filters['styles'] ?? null, function ($q, $tags) {
                foreach ($tags as $tag) {
                    $q->whereHas('styles', fn ($t) => $t->where('slug', $tag));
                }
            })
            ->when($filters['min_rating'] ?? null, fn ($q, $r) =>
                $q->where('rating', '>=', $r)
            )
            ->with(['genres', 'platforms', 'styles'])
        ->get();
    }

    public function getGame(int $id): JsonResponse
    {
        $game = Game::with(['screenshots', 'stores', 'trailers'])->findOrFail($id);

        $cacheKey = "game_description_pt_{$id}";

        $translatedDescription = Cache::remember($cacheKey, now()->addDay(), function () use ($game) {
            return $game->description 
                ? $this->translationService->translate($game->description, 'PT-BR') 
                : 'Descrição não disponível.';
        });

        return response()->json([
            'id'           => $game->id,
            'name'         => $game->name,
            'description'  => $translatedDescription,
            'cover_image'  => $game->cover_image,
            'rating'       => $game->rating,
            'released_at'  => $game->released_at ? $game->released_at->format('d/m/Y') : 'N/A',
            'screenshots'  => $game->screenshots->pluck('image'),
            'trailer'      => $game->trailers->url ?? '',
            'stores'       => $game->stores->map(function ($store) {
                return [
                    'name' => $store->name,
                    'url'  => $store->pivot->url_store,
                ];
            }),
        ]);
    }
}
