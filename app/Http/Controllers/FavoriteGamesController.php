<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteGamesController extends Controller
{
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

    public function showUserFavoriteGames(Request $request): JsonResponse
    {
        $user = $request->user();

        $favorites = $user->favoriteGames()->get();

        return response()->json($favorites);
    }

}
