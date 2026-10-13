<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicacaoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $idUsuario = $request->user()->id_usuario;


        // =====================================
        // CONEXÕES ACEITAS DO USUÁRIO
        // =====================================

        $conexoes = Conexao::where(
            'status_conexao',
            'ACEITA'
        )
            ->where(function ($query) use ($idUsuario) {

                $query
                    ->where(
                        'id_usuario_solicitante',
                        $idUsuario
                    )
                    ->orWhere(
                        'id_usuario_destino',
                        $idUsuario
                    );

            })
            ->get([
                'id_usuario_solicitante',
                'id_usuario_destino',
            ]);


        // =====================================
        // IDS DOS USUÁRIOS CONECTADOS
        // =====================================

        $idsConexoes = $conexoes
            ->map(function ($conexao) use ($idUsuario) {

                if (
                    (int) $conexao->id_usuario_solicitante ===
                    (int) $idUsuario
                ) {

                    return (int) $conexao->id_usuario_destino;

                }


                return (int) $conexao->id_usuario_solicitante;

            })
            ->values()
            ->all();


        // =====================================
        // PUBLICAÇÕES
        // =====================================

        $publicacoes = Publicacao::with([
            'usuario:id_usuario,nome_usuario,foto_usuario'
        ])

            // =====================================
            // QUANTIDADE DE CURTIDAS
            // =====================================

            ->withCount('curtidas')


            // =====================================
            // QUANTIDADE DE COMENTÁRIOS ATIVOS
            // =====================================

            ->withCount([
                'comentarios as comentarios_count' => function ($query) {

                    $query->where(
                        'status_comentario_publicacao',
                        'ATIVO'
                    );

                }
            ])


            // =====================================
            // USUÁRIO LOGADO CURTIU?
            // =====================================

            ->withExists([
                'curtidas as curtido_por_mim' => function ($query) use ($idUsuario) {

                    $query->where(
                        'id_usuario',
                        $idUsuario
                    );

                }
            ])


            // =====================================
            // SOMENTE PUBLICAÇÕES ATIVAS
            // =====================================

            ->where(
                'status_publicacao',
                'ATIVO'
            )


            // =====================================
            // REGRA DE VISIBILIDADE DO FEED
            // =====================================

            ->where(function ($query) use (
                $idUsuario,
                $idsConexoes
            ) {

                // ---------------------------------
                // 1. PRÓPRIAS PUBLICAÇÕES
                // ---------------------------------

                $query->where(
                    'id_usuario',
                    $idUsuario
                );


                // ---------------------------------
                // 2. ADMINISTRADOR E PALESTRANTE
                //    SÃO VISÍVEIS PARA TODOS
                // ---------------------------------

                $query->orWhereHas(
                    'usuario',
                    function ($usuarioQuery) {

                        $usuarioQuery->whereIn(
                            'perfil_usuario',
                            [
                                'administrador',
                                'palestrante',
                            ]
                        );

                    }
                );


                // ---------------------------------
                // 3. USUÁRIOS CONECTADOS
                // ---------------------------------

                if (!empty($idsConexoes)) {

                    $query->orWhereIn(
                        'id_usuario',
                        $idsConexoes
                    );

                }

            })


            // =====================================
            // MAIS RECENTES PRIMEIRO
            // =====================================

            ->orderByDesc(
                'criado_em_publicacao'
            )

            ->get();


        return response()->json([
            'success' => true,
            'data' => $publicacoes,
        ]);
    }
}