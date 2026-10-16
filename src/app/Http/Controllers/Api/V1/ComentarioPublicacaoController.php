<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ComentarioPublicacao;
use App\Models\Notificacao;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComentarioPublicacaoController extends Controller
{
    // =============================================================
    // LISTAR COMENTÁRIOS
    // =============================================================

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


    // =============================================================
    // CRIAR COMENTÁRIO
    // =============================================================

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

        $usuario =
            $request->user();

        $publicacao =
            Publicacao::where(
                'id_publicacao',
                $id
            )
                ->where(
                    'status_publicacao',
                    'ATIVO'
                )
                ->firstOrFail();


        // =========================================================
        // CRIAR COMENTÁRIO
        // =========================================================

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


        // =========================================================
        // CRIAR NOTIFICAÇÃO
        // =========================================================
        //
        // Só notifica se quem comentou for diferente
        // do autor da publicação.
        //

        if (
            (int) $publicacao->id_usuario !==
            (int) $usuario->id_usuario
        ) {

            Notificacao::create([
                'id_usuario_destino' =>
                    $publicacao->id_usuario,

                'id_usuario_origem' =>
                    $usuario->id_usuario,

                'tipo_notificacao' =>
                    'NOVO_COMENTARIO',

                'titulo_notificacao' =>
                    $usuario->nome_usuario
                    . ' comentou na sua publicação.',

                'mensagem_notificacao' =>
                    Str::limit(
                        $request->texto,
                        120
                    ),

                'id_referencia' =>
                    $publicacao->id_publicacao,

                'tipo_referencia' =>
                    'PUBLICACAO',

                'lida_notificacao' =>
                    false,
            ]);
        }


        // =========================================================
        // TOTAL DE COMENTÁRIOS
        // =========================================================

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


        // =========================================================
        // RESPOSTA
        // =========================================================

        return response()->json([
            'success' => true,

            'message' =>
                'Comentário publicado.',

            'data' => [
                'comentario' =>
                    $comentario,

                'comentarios_count' =>
                    $totalComentarios,
            ],
        ], 201);
    }
}