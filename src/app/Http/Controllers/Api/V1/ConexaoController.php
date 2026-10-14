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
    /**
     * Lista conexões aceitas do usuário autenticado.
     */
    public function index(Request $request): JsonResponse
    {
        $idUsuario = $request->user()->id_usuario;

        $conexoes = Conexao::with([
            'solicitante:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
            'destino:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
        ])
            ->where('status_conexao', 'ACEITA')
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
            ->orderByDesc('atualizado_em_conexao')
            ->get();


        $dados = $conexoes->map(
            function ($conexao) use ($idUsuario) {

                $usuarioConectado =
                    $conexao->id_usuario_solicitante === $idUsuario
                        ? $conexao->destino
                        : $conexao->solicitante;


                return [
                    'id_conexao' =>
                        $conexao->id_conexao,

                    'status_conexao' =>
                        $conexao->status_conexao,

                    'usuario' =>
                        $usuarioConectado,

                    'criado_em_conexao' =>
                        $conexao->criado_em_conexao,

                    'atualizado_em_conexao' =>
                        $conexao->atualizado_em_conexao,
                ];
            }
        );


        return response()->json([
            'success' => true,
            'data' => $dados,
        ]);
    }


    /**
     * Solicitações recebidas pelo usuário autenticado.
     */
    public function solicitacoes(Request $request): JsonResponse
    {
        $idUsuario = $request->user()->id_usuario;

        $solicitacoes = Conexao::with([
            'solicitante:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
        ])
            ->where(
                'id_usuario_destino',
                $idUsuario
            )
            ->where(
                'status_conexao',
                'PENDENTE'
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


    /**
     * Solicitações enviadas pelo usuário autenticado.
     */
    public function enviadas(Request $request): JsonResponse
    {
        $idUsuario = $request->user()->id_usuario;

        $solicitacoes = Conexao::with([
            'destino:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
        ])
            ->where(
                'id_usuario_solicitante',
                $idUsuario
            )
            ->where(
                'status_conexao',
                'PENDENTE'
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


    /**
     * Envia solicitação de conexão.
     */
    public function store(
        Request $request,
        int $idUsuario
    ): JsonResponse {

        $usuarioLogado =
            $request->user();


        if (
            $usuarioLogado->id_usuario ===
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


        /**
         * Verifica a conexão nos dois sentidos:
         *
         * A -> B
         * ou
         * B -> A
         */
        $conexaoExistente =
            Conexao::where(
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


            /**
             * Se havia sido recusada,
             * permite uma nova solicitação.
             */
            $conexaoExistente->update([
                'id_usuario_solicitante' =>
                    $usuarioLogado->id_usuario,

                'id_usuario_destino' =>
                    $idUsuario,

                'status_conexao' =>
                    'PENDENTE',
            ]);


            $this->criarNotificacaoSolicitacao(
                $usuarioLogado,
                $usuarioDestino,
                $conexaoExistente->id_conexao
            );


            return response()->json([
                'success' => true,
                'message' =>
                    'Solicitação de conexão enviada.',
                'data' =>
                    $conexaoExistente->fresh(),
            ]);
        }


        $conexao = Conexao::create([
            'id_usuario_solicitante' =>
                $usuarioLogado->id_usuario,

            'id_usuario_destino' =>
                $idUsuario,

            'status_conexao' =>
                'PENDENTE',
        ]);


        $this->criarNotificacaoSolicitacao(
            $usuarioLogado,
            $usuarioDestino,
            $conexao->id_conexao
        );


        return response()->json([
            'success' => true,
            'message' =>
                'Solicitação de conexão enviada.',
            'data' => $conexao,
        ], 201);
    }


    /**
     * Aceita solicitação.
     *
     * Apenas quem recebeu pode aceitar.
     */
    public function aceitar(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $usuarioLogado =
            $request->user();


        $conexao =
            Conexao::where(
                'id_conexao',
                $idConexao
            )
                ->where(
                    'id_usuario_destino',
                    $usuarioLogado->id_usuario
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


        $conexao->update([
            'status_conexao' =>
                'ACEITA',
        ]);


        // A solicitação recebida deixa de ficar pendente
        // na central de notificações do destinatário.
        $this->marcarSolicitacaoComoLida(
            $conexao
        );


        // Quem enviou a solicitação recebe a confirmação.
        Notificacao::create([
            'id_usuario_destino' =>
                $conexao->id_usuario_solicitante,

            'id_usuario_origem' =>
                $usuarioLogado->id_usuario,

            'tipo_notificacao' =>
                'CONEXAO_ACEITA',

            'titulo_notificacao' =>
                $usuarioLogado->nome_usuario
                . ' aceitou sua solicitação de conexão.',

            'mensagem_notificacao' =>
                'Vocês agora fazem parte da mesma rede de conexões.',

            'id_referencia' =>
                $conexao->id_conexao,

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
                $conexao->fresh(),
        ]);
    }


    /**
     * Recusa solicitação.
     *
     * Apenas quem recebeu pode recusar.
     */
    public function recusar(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $conexao =
            Conexao::where(
                'id_conexao',
                $idConexao
            )
                ->where(
                    'id_usuario_destino',
                    $request->user()->id_usuario
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


        $conexao->update([
            'status_conexao' =>
                'RECUSADA',
        ]);


        // A notificação de solicitação deixa de ficar pendente.
        // Não criamos notificação de "conexão recusada".
        $this->marcarSolicitacaoComoLida(
            $conexao
        );


        return response()->json([
            'success' => true,
            'message' =>
                'Solicitação recusada.',
            'data' =>
                $conexao->fresh(),
        ]);
    }


    /**
     * Remove uma conexão existente.
     */
    public function destroy(
        Request $request,
        int $idConexao
    ): JsonResponse {

        $idUsuario =
            $request->user()->id_usuario;


        $conexao =
            Conexao::where(
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


        $conexao->delete();


        return response()->json([
            'success' => true,
            'message' =>
                'Conexão removida com sucesso.',
        ]);
    }


    /**
     * Cria a notificação enviada ao usuário
     * que recebeu uma solicitação de conexão.
     */
    private function criarNotificacaoSolicitacao(
        $usuarioOrigem,
        $usuarioDestino,
        int $idConexao
    ): void {

        Notificacao::create([
            'id_usuario_destino' =>
                $usuarioDestino->id_usuario,

            'id_usuario_origem' =>
                $usuarioOrigem->id_usuario,

            'tipo_notificacao' =>
                'SOLICITACAO_CONEXAO',

            'titulo_notificacao' =>
                $usuarioOrigem->nome_usuario
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


    /**
     * Marca a notificação correspondente à solicitação
     * como lida depois de aceitar ou recusar.
     */
    private function marcarSolicitacaoComoLida(
        Conexao $conexao
    ): void {

        Notificacao::where(
            'id_usuario_destino',
            $conexao->id_usuario_destino
        )
            ->where(
                'id_usuario_origem',
                $conexao->id_usuario_solicitante
            )
            ->where(
                'tipo_notificacao',
                'SOLICITACAO_CONEXAO'
            )
            ->where(
                'id_referencia',
                $conexao->id_conexao
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
}
