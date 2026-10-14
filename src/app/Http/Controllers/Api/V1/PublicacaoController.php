<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conexao;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicacaoController extends Controller
{
    // =============================================================
    // LISTAR PUBLICAÇÕES
    // =============================================================

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

            ->withCount('curtidas')

            ->withCount([
                'comentarios as comentarios_count' => function ($query) {

                    $query->where(
                        'status_comentario_publicacao',
                        'ATIVO'
                    );

                }
            ])

            ->withExists([
                'curtidas as curtido_por_mim' => function ($query) use ($idUsuario) {

                    $query->where(
                        'id_usuario',
                        $idUsuario
                    );

                }
            ])

            ->where(
                'status_publicacao',
                'ATIVO'
            )

            ->where(function ($query) use (
                $idUsuario,
                $idsConexoes
            ) {

                // PRÓPRIAS PUBLICAÇÕES

                $query->where(
                    'id_usuario',
                    $idUsuario
                );


                // ADMINISTRADORES E PALESTRANTES

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


                // USUÁRIOS CONECTADOS

                if (!empty($idsConexoes)) {

                    $query->orWhereIn(
                        'id_usuario',
                        $idsConexoes
                    );

                }

            })

            ->orderByDesc(
                'criado_em_publicacao'
            )

            ->get();


        return response()->json([
            'success' => true,
            'data' => $publicacoes,
        ]);
    }


    // =============================================================
    // CRIAR PUBLICAÇÃO PELO APP
    // =============================================================

    public function store(Request $request): JsonResponse
    {
        $request->validate(
            [
                'texto_publicacao' => [
                    'nullable',
                    'required_without:midia_publicacao',
                    'string',
                    'max:5000',
                ],

                'midia_publicacao' => [
                    'nullable',
                    'required_without:texto_publicacao',
                    'file',
                    'mimes:jpg,jpeg,png,webp',
                    'max:20480',
                ],
            ],
            [
                'texto_publicacao.required_without' =>
                    'Informe um texto ou adicione uma imagem.',

                'texto_publicacao.max' =>
                    'O texto da publicação não pode ultrapassar 5000 caracteres.',

                'midia_publicacao.required_without' =>
                    'Adicione uma imagem ou informe o texto da publicação.',

                'midia_publicacao.mimes' =>
                    'A publicação aceita somente imagens JPG, JPEG, PNG ou WEBP.',

                'midia_publicacao.max' =>
                    'A imagem não pode ultrapassar 20 MB.',
            ]
        );


        // =====================================
        // USUÁRIO AUTENTICADO
        // =====================================

        $usuario = $request->user();


        // =====================================
        // IMAGEM
        // =====================================

        [$tipoMidia, $caminhoMidia] =
            $this->salvarImagem($request);


        // =====================================
        // CRIAR PUBLICAÇÃO
        // =====================================

        $publicacao = Publicacao::create([
            'id_usuario' =>
                $usuario->id_usuario,

            'id_evento' =>
                null,

            'texto_publicacao' =>
                $request->texto_publicacao,

            'tipo_midia_publicacao' =>
                $tipoMidia,

            'midia_publicacao' =>
                $caminhoMidia,

            'status_publicacao' =>
                'ATIVO',
        ]);


        // =====================================
        // CARREGAR AUTOR
        // =====================================

        $publicacao->load([
            'usuario:id_usuario,nome_usuario,foto_usuario'
        ]);


        // =====================================
        // CAMPOS UTILIZADOS PELO FEED
        // =====================================

        $publicacao->setAttribute(
            'curtidas_count',
            0
        );

        $publicacao->setAttribute(
            'comentarios_count',
            0
        );

        $publicacao->setAttribute(
            'curtido_por_mim',
            false
        );


        return response()->json([
            'success' => true,
            'message' =>
                'Publicação criada com sucesso.',
            'data' => $publicacao,
        ], 201);
    }


    // =============================================================
    // SALVAR IMAGEM
    // =============================================================

    private function salvarImagem(
        Request $request
    ): array {

        if (
            !$request->hasFile(
                'midia_publicacao'
            )
        ) {

            return [
                null,
                null,
            ];

        }


        $arquivo =
            $request->file(
                'midia_publicacao'
            );


        $extensao = strtolower(
            $arquivo
                ->getClientOriginalExtension()
        );


        $nomeArquivo =
            time()
            . '_'
            . uniqid()
            . '.'
            . $extensao;


        $diretorio = public_path(
            'conexao360/uploads/publicacoes/'
        );


        if (
            !file_exists(
                $diretorio
            )
        ) {

            mkdir(
                $diretorio,
                0755,
                true
            );

        }


        $arquivo->move(
            $diretorio,
            $nomeArquivo
        );


        return [
            'IMAGEM',
            'uploads/publicacoes/'
                . $nomeArquivo,
        ];
    }
}