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
        $usuarioLogado = $request->user();
        $idUsuario = $usuarioLogado->id_usuario;
        $perfilUsuario = $usuarioLogado->perfil_usuario;

        $query = Publicacao::with([
            'usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
        ])
            ->withCount('curtidas')
            ->withCount('denuncias')
            ->withCount([
                'comentarios as comentarios_count' => function ($query) {
                    $query->where('status_comentario_publicacao', 'ATIVO');
                },
            ])
            ->withExists([
                'curtidas as curtido_por_mim' => function ($query) use ($idUsuario) {
                    $query->where('id_usuario', $idUsuario);
                },
                'denuncias as denunciado_por_mim' => function ($query) use ($idUsuario) {
                    $query->where('id_usuario_denunciante', $idUsuario);
                },
            ])
            ->where('status_publicacao', 'ATIVO');

        // Administradores e palestrantes visualizam todas as publicações ATIVAS.
        if (in_array($perfilUsuario, ['administrador', 'palestrante'], true)) {
            return response()->json([
                'success' => true,
                'data' => $query->orderByDesc('criado_em_publicacao')->get(),
            ]);
        }

        // Usuário comum visualiza seus posts, os de admin/palestrantes
        // e os de usuários com os quais possui conexão ACEITA.
        $conexoes = Conexao::where('status_conexao', 'ACEITA')
            ->where(function ($query) use ($idUsuario) {
                $query->where('id_usuario_solicitante', $idUsuario)
                    ->orWhere('id_usuario_destino', $idUsuario);
            })
            ->get(['id_usuario_solicitante', 'id_usuario_destino']);

        $idsConexoes = $conexoes->map(function ($conexao) use ($idUsuario) {
            return (int) $conexao->id_usuario_solicitante === (int) $idUsuario
                ? (int) $conexao->id_usuario_destino
                : (int) $conexao->id_usuario_solicitante;
        })->unique()->values()->all();

        $query->where(function ($query) use ($idUsuario, $idsConexoes) {
            $query->where('id_usuario', $idUsuario)
                ->orWhereHas('usuario', function ($usuarioQuery) {
                    $usuarioQuery->whereIn('perfil_usuario', ['administrador', 'palestrante'])
                        ->where('status_usuario', 'ATIVO');
                });

            if (!empty($idsConexoes)) {
                $query->orWhereIn('id_usuario', $idsConexoes);
            }
        });

        return response()->json([
            'success' => true,
            'data' => $query->orderByDesc('criado_em_publicacao')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'texto_publicacao' => [
                'nullable', 'required_without:midia_publicacao', 'string', 'max:5000',
            ],
            'midia_publicacao' => [
                'nullable', 'required_without:texto_publicacao', 'file',
                'mimes:jpg,jpeg,png,webp', 'max:20480',
            ],
        ], [
            'texto_publicacao.required_without' => 'Informe um texto ou adicione uma imagem.',
            'texto_publicacao.max' => 'O texto da publicação não pode ultrapassar 5000 caracteres.',
            'midia_publicacao.required_without' => 'Adicione uma imagem ou informe o texto da publicação.',
            'midia_publicacao.mimes' => 'A publicação aceita somente imagens JPG, JPEG, PNG ou WEBP.',
            'midia_publicacao.max' => 'A imagem não pode ultrapassar 20 MB.',
        ]);

        [$tipoMidia, $caminhoMidia] = $this->salvarImagem($request);

        $publicacao = Publicacao::create([
            'id_usuario' => $request->user()->id_usuario,
            'id_evento' => null,
            'texto_publicacao' => $request->texto_publicacao,
            'tipo_midia_publicacao' => $tipoMidia,
            'midia_publicacao' => $caminhoMidia,
            'status_publicacao' => 'ATIVO',
        ]);

        $publicacao->load([
            'usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
        ]);
        $publicacao->setAttribute('curtidas_count', 0);
        $publicacao->setAttribute('comentarios_count', 0);
        $publicacao->setAttribute('curtido_por_mim', false);
        $publicacao->setAttribute('denuncias_count', 0);
        $publicacao->setAttribute('denunciado_por_mim', false);

        return response()->json([
            'success' => true,
            'message' => 'Publicação criada com sucesso.',
            'data' => $publicacao,
        ], 201);
    }

    /**
     * "Excluir" no aplicativo: o autor retira seu post da exibição.
     * Mantém o registro para não quebrar denúncias, comentários e auditoria.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $publicacao = Publicacao::whereKey($id)->firstOrFail();

        if ((int) $publicacao->id_usuario !== (int) $request->user()->id_usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Você só pode excluir as suas próprias publicações.',
            ], 403);
        }

        if ($publicacao->status_publicacao !== 'ATIVO') {
            return response()->json([
                'success' => false,
                'message' => 'Esta publicação já não está disponível no feed.',
            ], 409);
        }

        $publicacao->update(['status_publicacao' => 'OCULTO']);

        return response()->json([
            'success' => true,
            'message' => 'Publicação removida do feed.',
            'data' => [
                'id_publicacao' => $publicacao->id_publicacao,
                'status_publicacao' => 'OCULTO',
            ],
        ]);
    }

    private function salvarImagem(Request $request): array
    {
        if (!$request->hasFile('midia_publicacao')) {
            return [null, null];
        }

        $arquivo = $request->file('midia_publicacao');
        $extensao = strtolower($arquivo->getClientOriginalExtension());
        $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;
        $diretorio = public_path('conexao360/uploads/publicacoes/');

        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        $arquivo->move($diretorio, $nomeArquivo);

        return ['IMAGEM', 'uploads/publicacoes/' . $nomeArquivo];
    }
}
