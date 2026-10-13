<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CurtidaPublicacao;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurtidaPublicacaoController extends Controller
{
    public function store(
        Request $request,
        int $id
    ): JsonResponse {

        $usuario = $request->user();

        $publicacao = Publicacao::where(
            'id_publicacao',
            $id
        )
            ->where(
                'status_publicacao',
                'ATIVO'
            )
            ->firstOrFail();

        CurtidaPublicacao::firstOrCreate([
            'id_publicacao' =>
                $publicacao->id_publicacao,

            'id_usuario' =>
                $usuario->id_usuario,
        ]);

        $totalCurtidas =
            CurtidaPublicacao::where(
                'id_publicacao',
                $publicacao->id_publicacao
            )->count();

        return response()->json([
            'success' => true,
            'message' => 'Publicação curtida.',
            'data' => [
                'curtido_por_mim' => true,
                'curtidas_count' => $totalCurtidas,
            ],
        ]);
    }


    public function destroy(
        Request $request,
        int $id
    ): JsonResponse {

        $usuario = $request->user();

        $publicacao = Publicacao::where(
            'id_publicacao',
            $id
        )
            ->where(
                'status_publicacao',
                'ATIVO'
            )
            ->firstOrFail();

        CurtidaPublicacao::where(
            'id_publicacao',
            $publicacao->id_publicacao
        )
            ->where(
                'id_usuario',
                $usuario->id_usuario
            )
            ->delete();

        $totalCurtidas =
            CurtidaPublicacao::where(
                'id_publicacao',
                $publicacao->id_publicacao
            )->count();

        return response()->json([
            'success' => true,
            'message' => 'Curtida removida.',
            'data' => [
                'curtido_por_mim' => false,
                'curtidas_count' => $totalCurtidas,
            ],
        ]);
    }
}