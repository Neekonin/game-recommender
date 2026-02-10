<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

Route::post('/register', [
    RegisterController::class,
  'register'
]);

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::get('/genres', [
    GenreController::class,
    'index'
]);

Route::get('/game-styles', [
    StyleController::class,
    'index'
]);

Route::get('/platforms', [
    PlatformController::class,
    'index'
]);

Route::middleware('auth:sanctum')->get(
    '/user',
    fn ($r) => $r->user()
);

Route::middleware('auth:sanctum')->get(
    '/recommendations',
    [RecommendationController::class, 'index']
);
