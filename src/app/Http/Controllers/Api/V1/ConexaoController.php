<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Notificacao;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConexaoController extends Controller
{
    private const PERFIS_GLOBAIS = [
        'administrador',
        'palestrante',
    ];

    // =====================================
    // LISTAR CONEXÕES
    // =====================================

    public function index(
        Request $request
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

        $idUsuario =
            $usuarioLogado
                ->id_usuario;

        // =================================
        // CONEXÕES AUTOMÁTICAS
        // =================================

        $queryAutomaticos =
            Usuarios::where(
                'status_usuario',
                'ATIVO'
            )
                ->where(
                    'id_usuario',
                    '<>',
                    $idUsuario
                );

        // ADM/Palestrante é conectado
        // automaticamente com todo mundo.
        if (
            !$this->ehPerfilGlobal(
                $usuarioLogado
                    ->perfil_usuario
            )
        ) {
            // Usuário comum possui conexão
            // automática somente com
            // ADM e palestrantes.
            $queryAutomaticos
                ->whereIn(
                    'perfil_usuario',
                    self::PERFIS_GLOBAIS
                );
        }

        $usuariosAutomaticos =
            $queryAutomaticos
                ->get([
                    'id_usuario',
                    'nome_usuario',
                    'foto_usuario',
                    'perfil_usuario',
                ]);

        $idsAutomaticos =
            $usuariosAutomaticos
                ->pluck(
                    'id_usuario'
                )
                ->map(
                    fn ($id) =>
                        (int) $id
                )
                ->all();

        $automaticas =
            $usuariosAutomaticos
                ->map(
                    function (
                        $usuario
                    ) {
                        return [
                            'id_conexao' =>
                                null,

                            'status_conexao' =>
                                'ACEITA',

                            'conexao_automatica' =>
                                true,

                            'usuario' =>
                                $usuario,

                            'criado_em_conexao' =>
                                null,

                            'atualizado_em_conexao' =>
                                null,
                        ];
                    }
                );

        // =================================
        // CONEXÕES USUÁRIO ↔ USUÁRIO
        // =================================

        $conexoes =
            Conexao::with([
                'solicitante:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',
                'destino:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',
            ])
                ->where(
                    'status_conexao',
                    'ACEITA'
                )
                ->where(
                    function ($query) use (
                        $idUsuario
                    ) {
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
                ->orderByDesc(
                    'atualizado_em_conexao'
                )
                ->get();

        $explicitas =
            $conexoes
                ->map(
                    function (
                        $conexao
                    ) use (
                        $idUsuario,
                        $idsAutomaticos
                    ) {
                        $usuarioConectado =
                            (int)
                            $conexao
                                ->id_usuario_solicitante ===
                            (int)
                            $idUsuario
                                ? $conexao
                                    ->destino
                                : $conexao
                                    ->solicitante;

                        if (
                            !$usuarioConectado
                        ) {
                            return null;
                        }

                        if (
                            $usuarioConectado
                                ->status_usuario !==
                            'ATIVO'
                        ) {
                            return null;
                        }

                        // Conexão automática não
                        // precisa aparecer duas vezes.
                        if (
                            in_array(
                                (int)
                                $usuarioConectado
                                    ->id_usuario,
                                $idsAutomaticos,
                                true
                            )
                        ) {
                            return null;
                        }

                        // Tabela de conexão fica
                        // responsável apenas
                        // usuário ↔ usuário.
                        if (
                            $usuarioConectado
                                ->perfil_usuario !==
                            'usuario'
                        ) {
                            return null;
                        }

                        return [
                            'id_conexao' =>
                                $conexao
                                    ->id_conexao,

                            'status_conexao' =>
                                $conexao
                                    ->status_conexao,

                            'conexao_automatica' =>
                                false,

                            'usuario' =>
                                $usuarioConectado,

                            'criado_em_conexao' =>
                                $conexao
                                    ->criado_em_conexao,

                            'atualizado_em_conexao' =>
                                $conexao
                                    ->atualizado_em_conexao,
                        ];
                    }
                )
                ->filter()
                ->values();

        $dados =
            $automaticas
                ->concat(
                    $explicitas
                )
                ->unique(
                    fn ($item) =>
                        $item['usuario']
                            ->id_usuario
                )
                ->sortBy(
                    fn ($item) =>
                        mb_strtolower(
                            $item['usuario']
                                ->nome_usuario
                        )
                )
                ->values();

        return response()->json([
            'success' => true,
            'data' => $dados,
        ]);
    }

    // =====================================
    // SOLICITAÇÕES RECEBIDAS
    // =====================================

    public function solicitacoes(
        Request $request
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

        if (
            $this->ehPerfilGlobal(
                $usuarioLogado
                    ->perfil_usuario
            )
        ) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $solicitacoes =
            Conexao::with([
                'solicitante:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
            ])
                ->where(
                    'id_usuario_destino',
                    $usuarioLogado
                        ->id_usuario
                )
                ->where(
                    'status_conexao',
                    'PENDENTE'
                )
                ->whereHas(
                    'solicitante',
                    function ($query) {
                        $query
                            ->where(
                                'perfil_usuario',
                                'usuario'
                            )
                            ->where(
                                'status_usuario',
                                'ATIVO'
                            );
                    }
                )
                ->orderByDesc(
                    'criado_em_conexao'
                )
                ->get();

        return response()->json([
            'success' => true,
            'data' => $solicitacoes,
        ]);
    }

    // =====================================
    // SOLICITAÇÕES ENVIADAS
    // =====================================

    public function enviadas(
        Request $request
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

        if (
            $this->ehPerfilGlobal(
                $usuarioLogado
                    ->perfil_usuario
            )
        ) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $solicitacoes =
            Conexao::with([
                'destino:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
            ])
                ->where(
                    'id_usuario_solicitante',
                    $usuarioLogado
                        ->id_usuario
                )
                ->where(
                    'status_conexao',
                    'PENDENTE'
                )
                ->whereHas(
                    'destino',
                    function ($query) {
                        $query
                            ->where(
                                'perfil_usuario',
                                'usuario'
                            )
                            ->where(
                                'status_usuario',
                                'ATIVO'
                            );
                    }
                )
                ->orderByDesc(
                    'criado_em_conexao'
                )
                ->get();

        return response()->json([
            'success' => true,
            'data' => $solicitacoes,
        ]);
    }

    // =====================================
    // ENVIAR SOLICITAÇÃO
    // =====================================

    public function store(
        Request $request,
        int $idUsuario
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

        if (
            (int)
            $usuarioLogado
                ->id_usuario ===
            (int)
            $idUsuario
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Você não pode se conectar consigo mesmo.',
            ], 422);
        }

        $usuarioDestino =
            Usuarios::where(
                'id_usuario',
                $idUsuario
            )
                ->where(
                    'status_usuario',
                    'ATIVO'
                )
                ->first();

        if (!$usuarioDestino) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Usuário não encontrado ou inativo.',
            ], 404);
        }

        // =================================
        // ADM / PALESTRANTE
        // =================================

        if (
            $this->ehPerfilGlobal(
                $usuarioLogado
                    ->perfil_usuario
            ) ||
            $this->ehPerfilGlobal(
                $usuarioDestino
                    ->perfil_usuario
            )
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Este perfil já faz parte da sua rede por padrão.',
            ], 409);
        }

        // =================================
        // SOMENTE USUÁRIO ↔ USUÁRIO
        // =================================

        if (
            $usuarioLogado
                ->perfil_usuario !==
            'usuario' ||
            $usuarioDestino
                ->perfil_usuario !==
            'usuario'
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Solicitações de conexão são permitidas apenas entre usuários.',
            ], 422);
        }

        $conexaoExistente =
            Conexao::where(
                function ($query) use (
                    $usuarioLogado,
                    $idUsuario
                ) {
                    $query
                        ->where(
                            'id_usuario_solicitante',
                            $usuarioLogado
                                ->id_usuario
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
                                $usuarioLogado
                                    ->id_usuario
                            );
                    }
                )
                ->first();

        if ($conexaoExistente) {
            if (
                $conexaoExistente
                    ->status_conexao ===
                'ACEITA'
            ) {
                return response()->json([
                    'success' => false,

                    'message' =>
                        'Vocês já são conexões.',
                ], 409);
            }

            if (
                $conexaoExistente
                    ->status_conexao ===
                'PENDENTE'
            ) {
                return response()->json([
                    'success' => false,

                    'message' =>
                        'Já existe uma solicitação de conexão pendente.',
                ], 409);
            }

            $conexaoExistente->update([
                'id_usuario_solicitante' =>
                    $usuarioLogado
                        ->id_usuario,

                'id_usuario_destino' =>
                    $idUsuario,

                'status_conexao' =>
                    'PENDENTE',
            ]);

            $this
                ->criarNotificacaoSolicitacao(
                    $usuarioLogado,
                    $usuarioDestino,
                    $conexaoExistente
                        ->id_conexao
                );

            return response()->json([
                'success' => true,

                'message' =>
                    'Solicitação de conexão enviada.',

                'data' =>
                    $conexaoExistente
                        ->fresh(),
            ]);
        }

        $conexao =
            Conexao::create([
                'id_usuario_solicitante' =>
                    $usuarioLogado
                        ->id_usuario,

                'id_usuario_destino' =>
                    $idUsuario,

                'status_conexao' =>
                    'PENDENTE',
            ]);

        $this
            ->criarNotificacaoSolicitacao(
                $usuarioLogado,
                $usuarioDestino,
                $conexao
                    ->id_conexao
            );

        return response()->json([
            'success' => true,

            'message' =>
                'Solicitação de conexão enviada.',

            'data' =>
                $conexao,
        ], 201);
    }

    // =====================================
    // ACEITAR
    // =====================================

    public function aceitar(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $usuarioLogado =
            $request->user();

        $conexao =
            Conexao::with([
                'solicitante',
                'destino',
            ])
                ->where(
                    'id_conexao',
                    $idConexao
                )
                ->where(
                    'id_usuario_destino',
                    $usuarioLogado
                        ->id_usuario
                )
                ->where(
                    'status_conexao',
                    'PENDENTE'
                )
                ->first();

        if (!$conexao) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Solicitação não encontrada.',
            ], 404);
        }

        if (
            !$conexao->solicitante ||
            !$conexao->destino ||
            $conexao
                ->solicitante
                ->perfil_usuario !==
                'usuario' ||
            $conexao
                ->destino
                ->perfil_usuario !==
                'usuario'
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Esta conexão é automática e não precisa ser aceita.',
            ], 409);
        }

        $conexao->update([
            'status_conexao' =>
                'ACEITA',
        ]);

        $this
            ->marcarSolicitacaoComoLida(
                $conexao
            );

        Notificacao::create([
            'id_usuario_destino' =>
                $conexao
                    ->id_usuario_solicitante,

            'id_usuario_origem' =>
                $usuarioLogado
                    ->id_usuario,

            'tipo_notificacao' =>
                'CONEXAO_ACEITA',

            'titulo_notificacao' =>
                $usuarioLogado
                    ->nome_usuario
                . ' aceitou sua solicitação de conexão.',

            'mensagem_notificacao' =>
                'Vocês agora fazem parte da mesma rede de conexões.',

            'id_referencia' =>
                $conexao
                    ->id_conexao,

            'tipo_referencia' =>
                'CONEXAO',

            'lida_notificacao' =>
                false,
        ]);

        return response()->json([
            'success' => true,

            'message' =>
                'Conexão aceita com sucesso.',

            'data' =>
                $conexao
                    ->fresh(),
        ]);
    }

    // =====================================
    // RECUSAR
    // =====================================

    public function recusar(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $conexao =
            Conexao::with([
                'solicitante',
                'destino',
            ])
                ->where(
                    'id_conexao',
                    $idConexao
                )
                ->where(
                    'id_usuario_destino',
                    $request
                        ->user()
                        ->id_usuario
                )
                ->where(
                    'status_conexao',
                    'PENDENTE'
                )
                ->first();

        if (!$conexao) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Solicitação não encontrada.',
            ], 404);
        }

        if (
            !$conexao->solicitante ||
            !$conexao->destino ||
            $conexao
                ->solicitante
                ->perfil_usuario !==
                'usuario' ||
            $conexao
                ->destino
                ->perfil_usuario !==
                'usuario'
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Esta conexão é automática e não precisa ser recusada.',
            ], 409);
        }

        $conexao->update([
            'status_conexao' =>
                'RECUSADA',
        ]);

        $this
            ->marcarSolicitacaoComoLida(
                $conexao
            );

        return response()->json([
            'success' => true,

            'message' =>
                'Solicitação recusada.',

            'data' =>
                $conexao
                    ->fresh(),
        ]);
    }

    // =====================================
    // REMOVER CONEXÃO
    // =====================================

    public function destroy(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $idUsuario =
            $request
                ->user()
                ->id_usuario;

        $conexao =
            Conexao::with([
                'solicitante',
                'destino',
            ])
                ->where(
                    'id_conexao',
                    $idConexao
                )
                ->where(
                    function ($query) use (
                        $idUsuario
                    ) {
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
                ->first();

        if (!$conexao) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Conexão não encontrada.',
            ], 404);
        }

        if (
            (
                $conexao->solicitante &&
                $this->ehPerfilGlobal(
                    $conexao
                        ->solicitante
                        ->perfil_usuario
                )
            ) ||
            (
                $conexao->destino &&
                $this->ehPerfilGlobal(
                    $conexao
                        ->destino
                        ->perfil_usuario
                )
            )
        ) {
            return response()->json([
                'success' => false,

                'message' =>
                    'Conexões com administradores e palestrantes são automáticas e não podem ser removidas.',
            ], 409);
        }

        $conexao->delete();

        return response()->json([
            'success' => true,

            'message' =>
                'Conexão removida com sucesso.',
        ]);
    }

    // =====================================
    // NOTIFICAÇÃO DE SOLICITAÇÃO
    // =====================================

    private function criarNotificacaoSolicitacao(
        $usuarioOrigem,
        $usuarioDestino,
        int $idConexao
    ): void {

        Notificacao::create([
            'id_usuario_destino' =>
                $usuarioDestino
                    ->id_usuario,

            'id_usuario_origem' =>
                $usuarioOrigem
                    ->id_usuario,

            'tipo_notificacao' =>
                'SOLICITACAO_CONEXAO',

            'titulo_notificacao' =>
                $usuarioOrigem
                    ->nome_usuario
                . ' enviou uma solicitação de conexão.',

            'mensagem_notificacao' =>
                'Você recebeu uma nova solicitação para ampliar sua rede.',

            'id_referencia' =>
                $idConexao,

            'tipo_referencia' =>
                'CONEXAO',

            'lida_notificacao' =>
                false,
        ]);
    }

    // =====================================
    // MARCAR SOLICITAÇÃO COMO LIDA
    // =====================================

    private function marcarSolicitacaoComoLida(
        Conexao $conexao
    ): void {

        Notificacao::where(
            'id_usuario_destino',
            $conexao
                ->id_usuario_destino
        )
            ->where(
                'id_usuario_origem',
                $conexao
                    ->id_usuario_solicitante
            )
            ->where(
                'tipo_notificacao',
                'SOLICITACAO_CONEXAO'
            )
            ->where(
                'id_referencia',
                $conexao
                    ->id_conexao
            )
            ->where(
                'tipo_referencia',
                'CONEXAO'
            )
            ->where(
                'lida_notificacao',
                false
            )
            ->update([
                'lida_notificacao' =>
                    true,
            ]);
    }

    // =====================================
    // PERFIL GLOBAL
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
}