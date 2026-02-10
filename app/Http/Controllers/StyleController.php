<?php

namespace App\Http\Controllers;

use App\Models\Style;
use Illuminate\Http\JsonResponse;

class StyleController extends Controller
{
    public function index(): JsonResponse
    {
        $styles = Style::all();
        return response()->json($styles);
    }
}
