<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteGamesController extends Controller
{
    /**
     * Alterna o estado de favorito de um jogo para o usuário autenticado.
     * @param Request $request
     * @param int|string $id ID do jogo
     * @return JsonResponse Retorna o novo estado de favorito
    */
    public function saveFavoriteGame(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        if ($user->favoriteGames()->where('game_id', $id)->exists()) {
            $user->favoriteGames()->detach($id);

            return response()->json(['favorited' => false]);
        }

        $user->favoriteGames()->attach($id);

        return response()->json(['favorited' => true]);
    }

    /**
     * Verifica se um jogo específico está favoritado pelo usuário.
     * @param Request $request
     * @param int|string $id  ID do jogo
     * @return JsonResponse Retorna se o jogo está favoritado ou não
    */
    public function isFavorited(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        $favorited = $user->favoriteGames()
            ->where('game_id', $id)
            ->exists();

        return response()->json([
            'favorited' => $favorited
        ]);
    }

    /**
     * Lista todos os jogos favoritados pelo usuário autenticado.
     * @param Request $request
     * @return JsonResponse retorna uma coleção de jogos favoritados
    */
    public function showUserFavoriteGames(Request $request): JsonResponse
    {
        $user = $request->user();

        $favorites = $user->favoriteGames()->get();

        return response()->json($favorites);
    }

}
