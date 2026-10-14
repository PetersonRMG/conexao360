<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function show(
        Request $request,
        int $idUsuario
    ): JsonResponse {

        $usuarioLogado = $request->user();


        // =====================================
        // BUSCAR USUÁRIO
        // =====================================

        $usuario = Usuarios::where(
            'id_usuario',
            $idUsuario
        )
            ->where(
                'status_usuario',
                'ATIVO'
            )
            ->first([
                'id_usuario',
                'nome_usuario',
                'foto_usuario',
                'area_atuacao_usuario',
                'perfil_usuario',
                'estado_usuario',
                'sobre_usuario',
            ]);


        if (!$usuario) {

            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.',
            ], 404);

        }


        // =====================================
        // TOTAL DE CONEXÕES
        // =====================================

        $conexoesCount = Conexao::where(
            'status_conexao',
            'ACEITA'
        )
            ->where(
                function ($query) use ($idUsuario) {

                    $query
                        ->where(
                            'id_usuario_solicitante',
                            $idUsuario
                        )
                        ->orWhere(
                            'id_usuario_destino',
                            $idUsuario
                        );

                }
            )
            ->count();


        // =====================================
        // PRÓPRIO PERFIL
        // =====================================

        if (
            (int) $usuarioLogado->id_usuario ===
            (int) $idUsuario
        ) {

            return response()->json([
                'success' => true,
                'data' => [
                    'usuario' => $usuario,
                    'conexoes_count' => $conexoesCount,
                    'status_conexao' => 'PROPRIO_PERFIL',
                    'id_conexao' => null,
                    'pode_conectar' => false,
                ],
            ]);

        }


        // =====================================
        // BUSCAR CONEXÃO ENTRE OS USUÁRIOS
        // =====================================

        $conexao = Conexao::where(
            function ($query) use (
                $usuarioLogado,
                $idUsuario
            ) {

                $query
                    ->where(
                        'id_usuario_solicitante',
                        $usuarioLogado->id_usuario
                    )
                    ->where(
                        'id_usuario_destino',
                        $idUsuario
                    );

            }
        )
            ->orWhere(
                function ($query) use (
                    $usuarioLogado,
                    $idUsuario
                ) {

                    $query
                        ->where(
                            'id_usuario_solicitante',
                            $idUsuario
                        )
                        ->where(
                            'id_usuario_destino',
                            $usuarioLogado->id_usuario
                        );

                }
            )
            ->first();


        // =====================================
        // STATUS DA CONEXÃO
        // =====================================

        $statusConexao = 'SEM_CONEXAO';
        $idConexao = null;


        if ($conexao) {

            $idConexao =
                $conexao->id_conexao;


            if (
                $conexao->status_conexao ===
                'ACEITA'
            ) {

                $statusConexao =
                    'CONECTADO';

            } elseif (
                $conexao->status_conexao ===
                'PENDENTE'
            ) {

                if (
                    (int) $conexao->id_usuario_solicitante ===
                    (int) $usuarioLogado->id_usuario
                ) {

                    $statusConexao =
                        'PENDENTE_ENVIADA';

                } else {

                    $statusConexao =
                        'PENDENTE_RECEBIDA';

                }

            }

        }


        // Apenas usuário comum entra
        // no fluxo de conexão

        $podeConectar =
            $usuario->perfil_usuario ===
            'usuario';


        return response()->json([
            'success' => true,
            'data' => [
                'usuario' => $usuario,
                'conexoes_count' => $conexoesCount,
                'status_conexao' => $statusConexao,
                'id_conexao' => $idConexao,
                'pode_conectar' => $podeConectar,
            ],
        ]);
    }
}