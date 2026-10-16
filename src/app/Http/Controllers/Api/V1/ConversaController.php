<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\Notificacao;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConversaController extends Controller
{
    private const PERFIS_GLOBAIS = [
        'administrador',
        'palestrante',
    ];


    // =============================================================
    // LISTAR CONVERSAS
    // =============================================================

    public function index(
        Request $request
    ): JsonResponse {

        $idUsuario =
            (int) $request
                ->user()
                ->id_usuario;


        $conversas =
            Conversa::with([

                'usuarioUm:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',

                'usuarioDois:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',

                'ultimaMensagem' => function ($query) {

                    $query->select([
                        'tbl_mensagens.id_mensagem',
                        'tbl_mensagens.id_conversa',
                        'tbl_mensagens.id_usuario_remetente',
                        'tbl_mensagens.texto_mensagem',
                        'tbl_mensagens.lida_mensagem',
                        'tbl_mensagens.criado_em_mensagem',
                    ]);
                },
            ])

                ->withCount([
                    'mensagens as nao_lidas_count' =>
                        function ($query) use (
                            $idUsuario
                        ) {

                            $query
                                ->where(
                                    'id_usuario_remetente',
                                    '!=',
                                    $idUsuario
                                )
                                ->where(
                                    'lida_mensagem',
                                    false
                                );
                        }
                ])

                ->where(
                    function ($query) use (
                        $idUsuario
                    ) {

                        $query
                            ->where(
                                'id_usuario_um',
                                $idUsuario
                            )
                            ->orWhere(
                                'id_usuario_dois',
                                $idUsuario
                            );
                    }
                )

                ->orderByDesc(
                    'atualizado_em_conversa'
                )

                ->get();


        $dados =
            $conversas->map(
                function (
                    Conversa $conversa
                ) use (
                    $idUsuario
                ) {

                    $outroUsuario =
                        (int)
                        $conversa->id_usuario_um ===
                        $idUsuario

                            ? $conversa
                                ->usuarioDois

                            : $conversa
                                ->usuarioUm;


                    return [
                        'id_conversa' =>
                            $conversa
                                ->id_conversa,

                        'usuario' =>
                            $outroUsuario,

                        'ultima_mensagem' =>
                            $conversa
                                ->ultimaMensagem,

                        'nao_lidas_count' =>
                            (int)
                            $conversa
                                ->nao_lidas_count,

                        'criado_em_conversa' =>
                            $conversa
                                ->criado_em_conversa,

                        'atualizado_em_conversa' =>
                            $conversa
                                ->atualizado_em_conversa,
                    ];
                }
            );


        return response()->json([
            'success' => true,
            'data' => $dados,
        ]);
    }


    // =============================================================
    // ABRIR OU CRIAR CONVERSA
    // =============================================================

    public function store(
        Request $request,
        int $idUsuario
    ): JsonResponse {

        $usuarioLogado =
            $request->user();


        $idUsuarioLogado =
            (int)
            $usuarioLogado
                ->id_usuario;


        // =====================================
        // NÃO CONVERSAR CONSIGO MESMO
        // =====================================

        if (
            $idUsuarioLogado ===
            $idUsuario
        ) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Você não pode iniciar uma conversa consigo mesmo.',
            ], 422);
        }


        // =====================================
        // USUÁRIO DESTINO
        // =====================================

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
                    'Usuário não encontrado.',
            ], 404);
        }


        // =====================================
        // VALIDAR PERMISSÃO
        // =====================================

        if (
            !$this->podeConversar(
                $usuarioLogado,
                $usuarioDestino
            )
        ) {

            return response()->json([
                'success' => false,

                'message' =>
                    'É necessário estar conectado a este usuário para iniciar uma conversa.',
            ], 403);
        }


        // =====================================
        // NORMALIZAR IDs
        // =====================================

        $idUsuarioUm =
            min(
                $idUsuarioLogado,
                $idUsuario
            );

        $idUsuarioDois =
            max(
                $idUsuarioLogado,
                $idUsuario
            );


        // =====================================
        // LOCALIZAR OU CRIAR
        // =====================================

        $conversa =
            Conversa::firstOrCreate([
                'id_usuario_um' =>
                    $idUsuarioUm,

                'id_usuario_dois' =>
                    $idUsuarioDois,
            ]);


        $conversa->load([
            'usuarioUm:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',

            'usuarioDois:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',
        ]);


        $outroUsuario =
            $idUsuarioUm ===
            $idUsuarioLogado

                ? $conversa
                    ->usuarioDois

                : $conversa
                    ->usuarioUm;


        return response()->json([
            'success' => true,

            'message' =>
                $conversa->wasRecentlyCreated

                    ? 'Conversa criada com sucesso.'

                    : 'Conversa localizada.',

            'data' => [
                'id_conversa' =>
                    $conversa
                        ->id_conversa,

                'usuario' =>
                    $outroUsuario,

                'nova_conversa' =>
                    $conversa
                        ->wasRecentlyCreated,
            ],
        ], $conversa->wasRecentlyCreated
            ? 201
            : 200
        );
    }


    // =============================================================
    // LISTAR MENSAGENS
    // =============================================================

    public function mensagens(
        Request $request,
        int $idConversa
    ): JsonResponse {

        $idUsuario =
            (int)
            $request
                ->user()
                ->id_usuario;


        $conversa =
            $this->buscarConversaDoUsuario(
                $idConversa,
                $idUsuario
            );


        if (!$conversa) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Conversa não encontrada.',
            ], 404);
        }


        // =====================================
        // MARCAR MENSAGENS RECEBIDAS COMO LIDAS
        // =====================================

        Mensagem::where(
            'id_conversa',
            $idConversa
        )
            ->where(
                'id_usuario_remetente',
                '!=',
                $idUsuario
            )
            ->where(
                'lida_mensagem',
                false
            )
            ->update([
                'lida_mensagem' =>
                    true,
            ]);


        // =====================================
        // MARCAR NOTIFICAÇÃO DO CHAT COMO LIDA
        // =====================================

        Notificacao::where(
            'id_usuario_destino',
            $idUsuario
        )
            ->where(
                'tipo_notificacao',
                'NOVA_MENSAGEM'
            )
            ->where(
                'tipo_referencia',
                'CONVERSA'
            )
            ->where(
                'id_referencia',
                $idConversa
            )
            ->where(
                'lida_notificacao',
                false
            )
            ->update([
                'lida_notificacao' =>
                    true,
            ]);


        // =====================================
        // BUSCAR MENSAGENS
        // =====================================

        $mensagens =
            Mensagem::with([
                'remetente:id_usuario,nome_usuario,foto_usuario'
            ])
                ->where(
                    'id_conversa',
                    $idConversa
                )
                ->orderBy(
                    'criado_em_mensagem'
                )
                ->orderBy(
                    'id_mensagem'
                )
                ->get();


        // =====================================
        // OUTRO USUÁRIO
        // =====================================

        $conversa->load([
            'usuarioUm:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',

            'usuarioDois:id_usuario,nome_usuario,foto_usuario,perfil_usuario,status_usuario',
        ]);


        $outroUsuario =
            (int)
            $conversa->id_usuario_um ===
            $idUsuario

                ? $conversa
                    ->usuarioDois

                : $conversa
                    ->usuarioUm;


        return response()->json([
            'success' => true,

            'data' => [
                'conversa' => [
                    'id_conversa' =>
                        $conversa
                            ->id_conversa,

                    'usuario' =>
                        $outroUsuario,
                ],

                'mensagens' =>
                    $mensagens,
            ],
        ]);
    }


    // =============================================================
    // ENVIAR MENSAGEM
    // =============================================================

    public function enviarMensagem(
        Request $request,
        int $idConversa
    ): JsonResponse {

        $request->validate(
            [
                'texto' => [
                    'required',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'texto.required' =>
                    'Digite uma mensagem.',

                'texto.max' =>
                    'A mensagem não pode ultrapassar 5000 caracteres.',
            ]
        );


        $usuarioLogado =
            $request->user();


        $idUsuario =
            (int)
            $usuarioLogado
                ->id_usuario;


        // =====================================
        // CONVERSA DO USUÁRIO
        // =====================================

        $conversa =
            $this->buscarConversaDoUsuario(
                $idConversa,
                $idUsuario
            );


        if (!$conversa) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Conversa não encontrada.',
            ], 404);
        }


        // =====================================
        // IDENTIFICAR DESTINATÁRIO
        // =====================================

        $idDestinatario =
            (int)
            $conversa->id_usuario_um ===
            $idUsuario

                ? (int)
                $conversa
                    ->id_usuario_dois

                : (int)
                $conversa
                    ->id_usuario_um;


        $usuarioDestino =
            Usuarios::where(
                'id_usuario',
                $idDestinatario
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
                    'O destinatário desta conversa não está disponível.',
            ], 404);
        }


        // =====================================
        // REVALIDAR PERMISSÃO
        // =====================================

        if (
            !$this->podeConversar(
                $usuarioLogado,
                $usuarioDestino
            )
        ) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Você precisa estar conectado a este usuário para enviar mensagens.',
            ], 403);
        }


        // =====================================
        // TEXTO
        // =====================================

        $texto =
            trim(
                $request->texto
            );


        // =====================================
        // CRIAR MENSAGEM
        // =====================================

        $mensagem =
            Mensagem::create([
                'id_conversa' =>
                    $conversa
                        ->id_conversa,

                'id_usuario_remetente' =>
                    $idUsuario,

                'texto_mensagem' =>
                    $texto,

                'lida_mensagem' =>
                    false,
            ]);


        // =====================================
        // ATUALIZAR ORDEM DA CONVERSA
        // =====================================

        $conversa->touch();


        // =====================================
        // NOTIFICAÇÃO DE NOVA MENSAGEM
        // =====================================
        //
        // Mantemos apenas uma notificação NÃO LIDA
        // por conversa.
        //
        // Se já existir uma não lida, atualizamos
        // com a mensagem mais recente.
        // =====================================

        $notificacao =
            Notificacao::where(
                'id_usuario_destino',
                $idDestinatario
            )
                ->where(
                    'tipo_notificacao',
                    'NOVA_MENSAGEM'
                )
                ->where(
                    'tipo_referencia',
                    'CONVERSA'
                )
                ->where(
                    'id_referencia',
                    $conversa
                        ->id_conversa
                )
                ->where(
                    'lida_notificacao',
                    false
                )
                ->first();


        if ($notificacao) {

            $notificacao->update([
                'id_usuario_origem' =>
                    $idUsuario,

                'titulo_notificacao' =>
                    'Nova mensagem de '
                    . $usuarioLogado
                        ->nome_usuario,

                'mensagem_notificacao' =>
                    Str::limit(
                        $texto,
                        120
                    ),
            ]);

        } else {

            Notificacao::create([
                'id_usuario_destino' =>
                    $idDestinatario,

                'id_usuario_origem' =>
                    $idUsuario,

                'tipo_notificacao' =>
                    'NOVA_MENSAGEM',

                'titulo_notificacao' =>
                    'Nova mensagem de '
                    . $usuarioLogado
                        ->nome_usuario,

                'mensagem_notificacao' =>
                    Str::limit(
                        $texto,
                        120
                    ),

                'id_referencia' =>
                    $conversa
                        ->id_conversa,

                'tipo_referencia' =>
                    'CONVERSA',

                'lida_notificacao' =>
                    false,
            ]);
        }


        // =====================================
        // CARREGAR REMETENTE
        // =====================================

        $mensagem->load([
            'remetente:id_usuario,nome_usuario,foto_usuario'
        ]);


        return response()->json([
            'success' => true,

            'message' =>
                'Mensagem enviada.',

            'data' =>
                $mensagem,
        ], 201);
    }


    // =============================================================
    // BUSCAR CONVERSA DO USUÁRIO
    // =============================================================

    private function buscarConversaDoUsuario(
        int $idConversa,
        int $idUsuario
    ): ?Conversa {

        return Conversa::where(
            'id_conversa',
            $idConversa
        )
            ->where(
                function ($query) use (
                    $idUsuario
                ) {

                    $query
                        ->where(
                            'id_usuario_um',
                            $idUsuario
                        )
                        ->orWhere(
                            'id_usuario_dois',
                            $idUsuario
                        );
                }
            )
            ->first();
    }


    // =============================================================
    // REGRA DE PERMISSÃO PARA CONVERSAR
    // =============================================================

    private function podeConversar(
        Usuarios $usuarioUm,
        Usuarios $usuarioDois
    ): bool {

        // =====================================
        // ADMIN / PALESTRANTE
        // =====================================

        if (
            in_array(
                $usuarioUm->perfil_usuario,
                self::PERFIS_GLOBAIS,
                true
            ) ||
            in_array(
                $usuarioDois->perfil_usuario,
                self::PERFIS_GLOBAIS,
                true
            )
        ) {

            return true;
        }


        // =====================================
        // SOMENTE USUÁRIOS COMUNS
        // =====================================

        if (
            $usuarioUm->perfil_usuario !==
            'usuario'
            ||
            $usuarioDois->perfil_usuario !==
            'usuario'
        ) {

            return false;
        }


        $idUsuarioUm =
            (int)
            $usuarioUm
                ->id_usuario;

        $idUsuarioDois =
            (int)
            $usuarioDois
                ->id_usuario;


        // =====================================
        // CONEXÃO ACEITA
        // =====================================

        return Conexao::where(
            'status_conexao',
            'ACEITA'
        )
            ->where(
                function ($query) use (
                    $idUsuarioUm,
                    $idUsuarioDois
                ) {

                    $query
                        ->where(
                            function ($query) use (
                                $idUsuarioUm,
                                $idUsuarioDois
                            ) {

                                $query
                                    ->where(
                                        'id_usuario_solicitante',
                                        $idUsuarioUm
                                    )
                                    ->where(
                                        'id_usuario_destino',
                                        $idUsuarioDois
                                    );
                            }
                        )

                        ->orWhere(
                            function ($query) use (
                                $idUsuarioUm,
                                $idUsuarioDois
                            ) {

                                $query
                                    ->where(
                                        'id_usuario_solicitante',
                                        $idUsuarioDois
                                    )
                                    ->where(
                                        'id_usuario_destino',
                                        $idUsuarioUm
                                    );
                            }
                        );
                }
            )
            ->exists();
    }
}