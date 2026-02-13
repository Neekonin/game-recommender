<?php

namespace App\Http\Controllers;

use App\Models\Style;
use Illuminate\Http\JsonResponse;

class StyleController extends Controller
{
    /**
     * Retorna a listagem de todos os estilos cadastrados.
     * @return JsonResponse Lista contendo id, name, slug e rawg_id.
    */
    public function index(): JsonResponse
    {
        $styles = Style::all();
        return response()->json($styles);
    }
}
