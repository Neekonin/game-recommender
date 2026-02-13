<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;
use App\Models\Game;

class RecommendationController extends Controller
{
    /**
     * Retorna uma lista de recomendações com base nos filtros ou histórico do usuário.
     * @param Request $request
     * @param RecommendationService $service
     * @return Collection Retorna uma coleção de Games
    */
    public function showRecommendation(Request $request, RecommendationService $service)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return $service->getRecommendation($request->all());
    }

    /**
     * Retorna os detalhes de um jogo específico através do serviço de recomendação.
     * @param Request $request
     * @param int $id ID do jogo
     * @param RecommendationService $service
     * @return mixed
     */
    public function showGame(Request $request, int $id, RecommendationService $service)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return $service->getGame($id);
    }
}
