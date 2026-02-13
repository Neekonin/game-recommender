<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\FavoriteGamesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

Route::post('/register', 
    [
        RegisterController::class,
        'register'
    ]
);

Route::post('/login', 
    [
        AuthController::class,
        'login'
    ]
);

Route::get('/genres', 
    [
        GenreController::class,
        'index'
    ]
);

Route::get('/game-styles', 
    [
        StyleController::class,
        'index'
    ]
);

Route::get('/platforms', 
    [
        PlatformController::class,
        'index'
    ]
);

Route::middleware('auth:sanctum')->get(
    '/user',
    function (Request $request) {
        return response()->json($request->user());
    }
);

Route::middleware('auth:sanctum')->post(
    '/logout',
    [
        AuthController::class,
        'logout'
    ]
);

Route::middleware('auth:sanctum')->get(
    '/recommendations',
    [
        RecommendationController::class,
        'showRecommendation'
    ]
);

Route::middleware('auth:sanctum')->get(
    '/game/{id}',
    [
        RecommendationController::class,
        'showGame'
    ]
);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favoriteGame/{id}',
    [
        FavoriteGamesController::class,
        'saveFavoriteGame'
    ]);
});

Route::middleware('auth:sanctum')->get(
    '/games/{id}/is-favorited',
    [
        FavoriteGamesController::class,
        'isFavorited'
    ]
);

Route::middleware('auth:sanctum')->get(
    '/user-favorite-games', 
    [
        FavoriteGamesController::class,
        'showUserFavoriteGames'
    ]
);

