<?php

namespace App\Http\Controllers;


use App\Models\Platform;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{
    /**
     * Retorna a listagem de todas as plataformas cadastradas.
     * @return JsonResponse Lista contendo id, name, slug e rawg_id.
    */
    public function index(): JsonResponse
    {
        $platforms = Platform::all();
        return response()->json($platforms);
    }
}
