<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;
use App\Models\Game;

class RecommendationController extends Controller
{
    public function index(Request $request, RecommendationService $service)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return $service->recommend($request->all());
    }

    public function showGame($id)
    {
        // Carrega o jogo com as relações necessárias
        $game = Game::with(['screenshots', 'stores', 'trailers'])->findOrFail($id);

        return response()->json([
            'id'           => $game->id,
            'name'         => $game->name,
            'description' => $game->description,
            'cover_image'  => $game->cover_image,
            'rating'       => $game->rating,
            'released_at'  => $game->released_at ? $game->released_at->format('d/m/Y') : 'N/A',
            // Retorna apenas as URLs das imagens
            'screenshots'  => $game->screenshots->pluck('image'),
            'trailer'      => $game->trailers->url ?? '',
            // Retorna as lojas com o link de compra da tabela pivô
            'stores'       => $game->stores->map(function ($store) {
                return [
                    'name' => $store->name,
                    'url'  => $store->pivot->url_store,
                ];
            }),
        ]);
    }
}
