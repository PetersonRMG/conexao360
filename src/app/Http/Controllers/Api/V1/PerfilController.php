<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    private const PERFIS_GLOBAIS = [
        'administrador',
        'palestrante',
    ];

    public function show(
        Request $request,
        int $idUsuario
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

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
                'message' =>
                    'Usuário não encontrado.',
            ], 404);
        }

        // =====================================
        // TOTAL DE CONEXÕES
        // =====================================

        $conexoesCount =
            $this->contarConexoes(
                $usuario
            );

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
                    'usuario' =>
                        $usuario,

                    'conexoes_count' =>
                        $conexoesCount,

                    'status_conexao' =>
                        'PROPRIO_PERFIL',

                    'id_conexao' =>
                        null,

                    'pode_conectar' =>
                        false,

                    'conexao_automatica' =>
                        false,
                ],
            ]);
        }

        // =====================================
        // ADM / PALESTRANTE
        // =====================================
        //
        // Se qualquer uma das pontas for
        // administrador ou palestrante,
        // a conexão existe automaticamente.
        //
        // Não precisa existir registro
        // em tbl_conexoes.
        // =====================================

        if (
            $this->ehPerfilGlobal(
                $usuarioLogado
                    ->perfil_usuario
            ) ||
            $this->ehPerfilGlobal(
                $usuario
                    ->perfil_usuario
            )
        ) {
            return response()->json([
                'success' => true,

                'data' => [
                    'usuario' =>
                        $usuario,

                    'conexoes_count' =>
                        $conexoesCount,

                    'status_conexao' =>
                        'CONECTADO',

                    'id_conexao' =>
                        null,

                    'pode_conectar' =>
                        false,

                    'conexao_automatica' =>
                        true,
                ],
            ]);
        }

        // =====================================
        // USUÁRIO COMUM ↔ USUÁRIO COMUM
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

        $statusConexao =
            'SEM_CONEXAO';

        $idConexao =
            null;

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
                    (int)
                    $conexao
                        ->id_usuario_solicitante ===
                    (int)
                    $usuarioLogado
                        ->id_usuario
                ) {
                    $statusConexao =
                        'PENDENTE_ENVIADA';

                } else {
                    $statusConexao =
                        'PENDENTE_RECEBIDA';
                }
            }
        }

        return response()->json([
            'success' => true,

            'data' => [
                'usuario' =>
                    $usuario,

                'conexoes_count' =>
                    $conexoesCount,

                'status_conexao' =>
                    $statusConexao,

                'id_conexao' =>
                    $idConexao,

                'pode_conectar' =>
                    true,

                'conexao_automatica' =>
                    false,
            ],
        ]);
    }

    // =====================================
    // VERIFICAR PERFIL GLOBAL
    // =====================================

    private function ehPerfilGlobal(
        ?string $perfil
    ): bool {
        return in_array(
            $perfil,
            self::PERFIS_GLOBAIS,
            true
        );
    }

    // =====================================
    // CONTAR CONEXÕES
    // =====================================

    private function contarConexoes(
        Usuarios $usuario
    ): int {

        // =================================
        // ADM / PALESTRANTE
        // =================================
        //
        // São conectados com todos
        // os usuários ativos.
        // =================================

        if (
            $this->ehPerfilGlobal(
                $usuario->perfil_usuario
            )
        ) {
            return Usuarios::where(
                'status_usuario',
                'ATIVO'
            )
                ->where(
                    'id_usuario',
                    '<>',
                    $usuario->id_usuario
                )
                ->count();
        }

        // =================================
        // USUÁRIO COMUM
        // =================================
        //
        // Conta:
        // - todos ADM/Palestrantes ativos;
        // - usuários comuns com conexão ACEITA.
        // =================================

        $conexoesGlobais =
            Usuarios::where(
                'status_usuario',
                'ATIVO'
            )
                ->whereIn(
                    'perfil_usuario',
                    self::PERFIS_GLOBAIS
                )
                ->where(
                    'id_usuario',
                    '<>',
                    $usuario->id_usuario
                )
                ->count();

        $conexoesAceitas =
            Conexao::where(
                'status_conexao',
                'ACEITA'
            )
                ->where(
                    function ($query) use (
                        $usuario
                    ) {
                        $query
                            ->where(
                                'id_usuario_solicitante',
                                $usuario->id_usuario
                            )
                            ->orWhere(
                                'id_usuario_destino',
                                $usuario->id_usuario
                            );
                    }
                )
                ->get([
                    'id_usuario_solicitante',
                    'id_usuario_destino',
                ]);

        $idsUsuariosComuns =
            $conexoesAceitas
                ->map(
                    function (
                        $conexao
                    ) use (
                        $usuario
                    ) {
                        if (
                            (int)
                            $conexao
                                ->id_usuario_solicitante ===
                            (int)
                            $usuario
                                ->id_usuario
                        ) {
                            return
                                $conexao
                                    ->id_usuario_destino;
                        }

                        return
                            $conexao
                                ->id_usuario_solicitante;
                    }
                )
                ->unique()
                ->values();

        $conexoesUsuariosComuns =
            Usuarios::whereIn(
                'id_usuario',
                $idsUsuariosComuns
            )
                ->where(
                    'status_usuario',
                    'ATIVO'
                )
                ->where(
                    'perfil_usuario',
                    'usuario'
                )
                ->count();

        return
            $conexoesGlobais +
            $conexoesUsuariosComuns;
    }
}