<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Autentica o usuário e gera um novo token de acesso.
     * @param Request $request Contém 'email' e 'password'
     * @return JsonResponse Retorna o objeto do usuário e o token plainText
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('spa-token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * Revoga todos os tokens do usuário autenticado, encerrando a sessão.
     * @param Request $request
     * @return JsonResponse
    */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout efetuado'
        ]);
    }
}
