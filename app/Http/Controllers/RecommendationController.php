<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;
use App\Models\Game;

class RecommendationController extends Controller
{
    public function showRecommendation(Request $request, RecommendationService $service)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return $service->getRecommendation($request->all());
    }

    public function showGame(Request $request, int $id, RecommendationService $service)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return $service->getGame($id);
    }
}
