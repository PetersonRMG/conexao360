<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
            'device_name' => 'required|string',
        ]);

        $usuario = Usuarios::where(
            'email_usuario',
            $request->email
        )->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha inválidos.',
            ], 401);
        }

        if (!Hash::check(
            $request->senha,
            $usuario->senha_usuario
        )) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha inválidos.',
            ], 401);
        }

        if ($usuario->status_usuario !== 'ATIVO') {
            return response()->json([
                'success' => false,
                'message' => 'Usuário inativo.',
            ], 403);
        }

        $token = $usuario
            ->createToken($request->device_name)
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso.',
            'data' => [
                'token' => $token,
                'usuario' => [
                    'id_usuario' => $usuario->id_usuario,
                    'nome_usuario' => $usuario->nome_usuario,
                    'email_usuario' => $usuario->email_usuario,
                    'perfil_usuario' => $usuario->perfil_usuario,
                ],
            ],
        ]);
    }
}
