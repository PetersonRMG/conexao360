<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ComentarioPublicacao;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComentarioPublicacaoController extends Controller
{
    public function index(
        Request $request,
        int $id
    ): JsonResponse {

        Publicacao::where(
            'id_publicacao',
            $id
        )
            ->where(
                'status_publicacao',
                'ATIVO'
            )
            ->firstOrFail();

        $comentarios =
            ComentarioPublicacao::with([
                'usuario:id_usuario,nome_usuario,foto_usuario'
            ])
                ->where(
                    'id_publicacao',
                    $id
                )
                ->where(
                    'status_comentario_publicacao',
                    'ATIVO'
                )
                ->orderBy(
                    'criado_em_comentario_publicacao'
                )
                ->get();

        return response()->json([
            'success' => true,
            'data' => $comentarios,
        ]);
    }


    public function store(
        Request $request,
        int $id
    ): JsonResponse {

        $request->validate([
            'texto' => [
                'required',
                'string',
            ],
        ]);

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

        $comentario =
            ComentarioPublicacao::create([
                'id_publicacao' =>
                    $publicacao->id_publicacao,

                'id_usuario' =>
                    $usuario->id_usuario,

                'texto_comentario_publicacao' =>
                    $request->texto,

                'status_comentario_publicacao' =>
                    'ATIVO',
            ]);

        $comentario->load([
            'usuario:id_usuario,nome_usuario,foto_usuario'
        ]);

        $totalComentarios =
            ComentarioPublicacao::where(
                'id_publicacao',
                $publicacao->id_publicacao
            )
                ->where(
                    'status_comentario_publicacao',
                    'ATIVO'
                )
                ->count();

        return response()->json([
            'success' => true,
            'message' => 'Comentário publicado.',
            'data' => [
                'comentario' => $comentario,
                'comentarios_count' =>
                    $totalComentarios,
            ],
        ], 201);
    }
}