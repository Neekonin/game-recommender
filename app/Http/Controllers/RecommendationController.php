<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;
use App\Http\Resources\GameRecommendationResource;

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
}
