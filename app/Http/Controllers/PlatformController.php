<?php

namespace App\Http\Controllers;


use App\Models\Platform;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{
    public function index(): JsonResponse
    {
        $platforms = Platform::all();
        return response()->json($platforms);
    }
}
