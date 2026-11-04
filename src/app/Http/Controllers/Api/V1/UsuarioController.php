<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

    // =============================================================
    // EXCLUIR A PRÓPRIA CONTA
    // =============================================================
    public function destroy(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'senha' => ['required', 'string', 'max:255'],
        ]);

        $usuario = $request->user();
        if (!Hash::check($dados['senha'], $usuario->senha_usuario)) {
            return response()->json([
                'success' => false,
                'message' => 'Senha atual incorreta.',
            ], 422);
        }

        $idUsuario = (int) $usuario->id_usuario;
        $fotoUsuario = (string) ($usuario->foto_usuario ?? '');
        $arquivosPublicacoes = [];

        // Nenhuma alteração é confirmada no banco se um dos deletes falhar.
        DB::transaction(function () use ($idUsuario, $dados, &$arquivosPublicacoes) {
            $usuario = Usuarios::query()->lockForUpdate()->findOrFail($idUsuario);
            if (!Hash::check($dados['senha'], $usuario->senha_usuario)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'senha' => 'Senha atual incorreta.',
                ]);
            }

            $publicacoes = DB::table('tbl_publicacoes')->where('id_usuario', $idUsuario);
            $idsPublicacoes = (clone $publicacoes)->pluck('id_publicacao')->all();
            $arquivosPublicacoes = (clone $publicacoes)->whereNotNull('midia_publicacao')
                ->pluck('midia_publicacao')->all();

            // Denúncias podem ter FK RESTRICT para usuários e publicações.
            DB::table('tbl_denuncias')->where('id_usuario_denunciante', $idUsuario)
                ->orWhereIn('id_publicacao', $idsPublicacoes)->delete();
            DB::table('tbl_denuncias')->where('id_usuario_moderador', $idUsuario)
                ->update(['id_usuario_moderador' => null]);

            DB::table('tbl_comentarios_publicacao')->where('id_usuario', $idUsuario)
                ->orWhereIn('id_publicacao', $idsPublicacoes)->delete();
            DB::table('tbl_curtidas_publicacao')->where('id_usuario', $idUsuario)
                ->orWhereIn('id_publicacao', $idsPublicacoes)->delete();
            DB::table('tbl_publicacoes')->where('id_usuario', $idUsuario)->delete();

            // Apaga votos dados e enquetes publicadas pelo usuário.
            $idsEnquetes = DB::table('tbl_enquetes')->where('id_usuario', $idUsuario)
                ->pluck('id_enquete')->all();
            DB::table('tbl_respostas')->where('id_usuario', $idUsuario)
                ->orWhereIn('id_enquete', $idsEnquetes)->delete();
            DB::table('tbl_enquetes')->where('id_usuario', $idUsuario)->delete();

            // Mensagens e conversas precisam sair antes da exclusão da conta:
            // suas FKs para usuários não possuem cascade na estrutura original.
            $idsConversas = DB::table('tbl_conversas')
                ->where('id_usuario_um', $idUsuario)
                ->orWhere('id_usuario_dois', $idUsuario)
                ->pluck('id_conversa')->all();
            DB::table('tbl_mensagens')->where('id_usuario_remetente', $idUsuario)
                ->orWhereIn('id_conversa', $idsConversas)->delete();
            DB::table('tbl_conversas')->whereIn('id_conversa', $idsConversas)->delete();

            DB::table('tbl_conexoes')->where('id_usuario_solicitante', $idUsuario)
                ->orWhere('id_usuario_destino', $idUsuario)->delete();
            DB::table('tbl_notificacoes')->where('id_usuario_destino', $idUsuario)
                ->orWhere('id_usuario_origem', $idUsuario)->delete();

            DB::table('tbl_conteudos')->where('id_usuario', $idUsuario)->delete();
            DB::table('tbl_ingressos')->where('id_usuario', $idUsuario)->delete();
            DB::table('tbl_palestras')->where('id_usuario', $idUsuario)->delete();
            DB::table('tbl_depoimentos')->where('id_usuario', $idUsuario)->delete();
            DB::table('tbl_chats')->where('id_usuario', $idUsuario)->delete();
            DB::table('tbl_codigos_verificacao')->where('email', $usuario->email_usuario)->delete();

            // Revoga todos os dispositivos, não apenas o token atual.
            $usuario->tokens()->delete();
            $usuario->delete();
        });

        // Arquivos físicos só são apagados depois do COMMIT. Caminhos são
        // limitados às pastas exclusivas de uploads; nunca apagar fotos padrão.
        try {
            if (preg_match('~^usuario/[a-f0-9-]{36}\.(jpg|jpeg|png|webp)$~i', $fotoUsuario)) {
                File::delete(public_path('dash/assets/img/' . $fotoUsuario));
            }
            foreach ($arquivosPublicacoes as $caminho) {
                if (is_string($caminho) && preg_match('~^uploads/publicacoes/[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)$~', $caminho)) {
                    File::delete(public_path('conexao360/' . $caminho));
                }
            }
        } catch (\Throwable $erro) {
            Log::warning('Falha ao remover arquivos após exclusão da conta.', [
                'id_usuario' => $idUsuario,
                'erro' => $erro->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Conta excluída com sucesso.',
        ]);
    }

}
