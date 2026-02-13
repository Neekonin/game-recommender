<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;


class GenreController extends Controller
{
    /**
     * Retorna a listagem completa de gêneros.
     * @return JsonResponse Lista contendo id, name, slug e rawg_id.
    */
    public function index(): JsonResponse
    {
        $genres = Genre::all();
        return response()->json($genres);
    }
}
