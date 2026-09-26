<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;

class PublicacaoController extends Controller
{
    public function index(): JsonResponse
    {
        $publicacoes = Publicacao::with([
            'usuario:id_usuario,nome_usuario,foto_usuario'
        ])
            ->where('status_publicacao', 'ATIVO')
            ->orderByDesc('criado_em_publicacao')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $publicacoes,
        ]);
    }
}
