<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
     public function index():JsonResponse
    {
        $users = Usuarios::where('status_usuario', 'ATIVO')
            ->inRandomOrder()
            ->get();

             return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

      
}
