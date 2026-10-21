<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    // =============================================================
    // LISTAR / PESQUISAR USUÁRIOS
    // =============================================================

    public function index(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'busca' => [
                'nullable',
                'string',
                'max:100',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);


        $busca = trim(
            (string) ($dados['busca'] ?? '')
        );


        $idUsuarioLogado =
            $request->user()->id_usuario;


        $query = Usuarios::query()
            ->select([
                'id_usuario',
                'nome_usuario',
                'foto_usuario',
                'area_atuacao_usuario',
                'perfil_usuario',
                'estado_usuario',
                'criado_em_usuario',
            ])
            ->where(
                'status_usuario',
                'ATIVO'
            )
            ->where(
                'id_usuario',
                '<>',
                $idUsuarioLogado
            );


        // =========================================================
        // FILTRO DE BUSCA
        // =========================================================

        if ($busca !== '') {

            $query->where(
                function ($subQuery) use ($busca) {

                    $subQuery
                        ->where(
                            'nome_usuario',
                            'like',
                            '%' . $busca . '%'
                        )
                        ->orWhere(
                            'area_atuacao_usuario',
                            'like',
                            '%' . $busca . '%'
                        )
                        ->orWhere(
                            'estado_usuario',
                            'like',
                            '%' . $busca . '%'
                        );

                }
            );


            $query->orderBy(
                'nome_usuario'
            );

        } else {

            // Sem busca:
            // exibe primeiro os membros mais recentes.

            $query->orderByDesc(
                'criado_em_usuario'
            );

        }


        // =========================================================
        // PAGINAÇÃO
        // =========================================================

        $usuarios =
            $query->paginate(20);


        // =========================================================
        // RESPOSTA
        // =========================================================

        return response()->json([
            'success' => true,

            'data' =>
                $usuarios->items(),

            'meta' => [
                'current_page' =>
                    $usuarios->currentPage(),

                'last_page' =>
                    $usuarios->lastPage(),

                'per_page' =>
                    $usuarios->perPage(),

                'total' =>
                    $usuarios->total(),
            ],
        ]);
    }


    // =============================================================
    // USUÁRIO LOGADO
    // =============================================================

    public function show(Request $request): JsonResponse
    {
        $usuario =
            $request->user();


        return response()->json([
            'success' => true,
            'data' => $usuario,
        ]);
    }


    // =============================================================
    // ATUALIZAR USUÁRIO LOGADO
    // =============================================================

    public function update(Request $request): JsonResponse
    {
        // O token Sanctum determina quem pode ser editado.
        // Nenhum ID fornecido pelo aplicativo é aceito nesta rota.

        /** @var Usuarios $usuario */

        $usuario =
            $request->user();


        $dados =
            $request->validate([
                'nome_usuario' => [
                    'sometimes',
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                ],

                'area_atuacao_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:150',
                ],

                'estado_usuario' => [
                    'sometimes',
                    'required',
                    'string',
                    'size:2',
                    'in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
                ],

                'sobre_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:200',
                ],

                'instagram_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'linkedin_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'youtube_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'tiktok_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'facebook_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'site_usuario' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'foto_usuario' => [
                    'sometimes',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:3072',
                ],
            ]);


        // No esquema original estes dois campos
        // não aceitam NULL.

        foreach (
            [
                'area_atuacao_usuario',
                'sobre_usuario',
            ]
            as $campo
        ) {

            if (
                array_key_exists(
                    $campo,
                    $dados
                )
                &&
                $dados[$campo] === null
            ) {

                $dados[$campo] = '';

            }

        }


        // A foto é tratada separadamente.

        unset(
            $dados['foto_usuario']
        );


        if (
            $request->hasFile(
                'foto_usuario'
            )
        ) {

            $diretorio =
                public_path(
                    'dash/assets/img/usuario'
                );


            File::ensureDirectoryExists(
                $diretorio
            );


            $arquivo =
                $request->file(
                    'foto_usuario'
                );


            $nomeArquivo =
                (string) Str::uuid()
                . '.'
                . $arquivo->extension();


            $arquivo->move(
                $diretorio,
                $nomeArquivo
            );


            $dados['foto_usuario'] =
                'usuario/'
                . $nomeArquivo;

        }


        // Apenas os campos validados são alterados.
        // Perfil, status, senha e e-mail
        // não podem ser modificados por esta rota.

        $usuario->fill(
            $dados
        );


        $usuario->save();


        return response()->json([
            'success' => true,

            'message' =>
                'Perfil atualizado com sucesso.',

            'data' =>
                $usuario->fresh(),
        ]);
    }
}