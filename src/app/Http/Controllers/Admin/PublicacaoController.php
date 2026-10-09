<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Publicacao;
use App\Models\Eventos;

class PublicacaoController extends Controller
{
    // =============================================================
    // ADMINISTRADOR / DRA
    // =============================================================

    public function index()
    {
        $publicacoes = Publicacao::with(['usuario', 'evento'])
            ->orderByDesc('criado_em_publicacao')
            ->get();

        $eventos = Eventos::orderByDesc('data_inicial_evento')
            ->get();

        return view(
            'admin.publicacoes.index',
            compact('publicacoes', 'eventos')
        );
    }


    public function store(Request $request)
    {
        $this->validarPublicacao($request);

        $usuario = Auth::guard('admin')->user();

        [$tipoMidia, $caminhoMidia] = $this->salvarImagem($request);

        Publicacao::create([
            'id_usuario' => $usuario->id_usuario,
            'id_evento' => $request->id_evento ?: null,
            'texto_publicacao' => $request->texto_publicacao,
            'tipo_midia_publicacao' => $tipoMidia,
            'midia_publicacao' => $caminhoMidia,
            'status_publicacao' => 'ATIVO',
        ]);

        return redirect()
            ->route('admin.publicacoes.index')
            ->with(
                'success',
                'Publicação criada com sucesso!'
            );
    }


    public function status(Request $request, $id)
    {
        $request->validate([
            'status_publicacao' => 'required|in:ATIVO,OCULTO',
        ]);

        $publicacao = Publicacao::findOrFail($id);

        $publicacao->update([
            'status_publicacao' => $request->status_publicacao,
        ]);

        return redirect()
            ->route('admin.publicacoes.index')
            ->with(
                'success',
                'Status da publicação atualizado com sucesso!'
            );
    }


    // =============================================================
    // PALESTRANTE
    // =============================================================

    public function indexPalestrante()
    {
        $usuario = Auth::guard('admin')->user();

        abort_unless(
            $usuario && $usuario->perfil_usuario === 'palestrante',
            403
        );

        $publicacoes = Publicacao::with(['usuario', 'evento'])
            ->where('id_usuario', $usuario->id_usuario)
            ->orderByDesc('criado_em_publicacao')
            ->get();

        $eventos = Eventos::orderByDesc('data_inicial_evento')
            ->get();

        return view(
            'palestrante.publicacoes.index',
            compact('publicacoes', 'eventos')
        );
    }


    public function storePalestrante(Request $request)
    {
        $usuario = Auth::guard('admin')->user();

        abort_unless(
            $usuario && $usuario->perfil_usuario === 'palestrante',
            403
        );

        $this->validarPublicacao($request);

        [$tipoMidia, $caminhoMidia] = $this->salvarImagem($request);

        Publicacao::create([
            'id_usuario' => $usuario->id_usuario,
            'id_evento' => $request->id_evento ?: null,
            'texto_publicacao' => $request->texto_publicacao,
            'tipo_midia_publicacao' => $tipoMidia,
            'midia_publicacao' => $caminhoMidia,
            'status_publicacao' => 'ATIVO',
        ]);

        return redirect()
            ->route('admin.palestrante.publicacoes.index')
            ->with(
                'success',
                'Publicação criada com sucesso!'
            );
    }


    public function statusPalestrante(Request $request, $id)
    {
        $usuario = Auth::guard('admin')->user();

        abort_unless(
            $usuario && $usuario->perfil_usuario === 'palestrante',
            403
        );

        $request->validate([
            'status_publicacao' => 'required|in:ATIVO,OCULTO',
        ]);

        // O filtro por id_usuario garante que o palestrante
        // só consiga alterar as próprias publicações.
        $publicacao = Publicacao::where(
            'id_usuario',
            $usuario->id_usuario
        )
            ->where('id_publicacao', $id)
            ->firstOrFail();

        $publicacao->update([
            'status_publicacao' => $request->status_publicacao,
        ]);

        return redirect()
            ->route('admin.palestrante.publicacoes.index')
            ->with(
                'success',
                'Status da publicação atualizado com sucesso!'
            );
    }


    // =============================================================
    // REGRAS COMPARTILHADAS
    // =============================================================

    private function validarPublicacao(Request $request): void
    {
        $request->validate(
            [
                'texto_publicacao' => [
                    'nullable',
                    'required_without:midia_publicacao',
                    'string',
                    'max:5000',
                ],

                'id_evento' => [
                    'nullable',
                    'exists:tbl_eventos,id_evento',
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

                'id_evento.exists' =>
                    'O evento selecionado é inválido.',
            ]
        );
    }


    private function salvarImagem(Request $request): array
    {
        if (!$request->hasFile('midia_publicacao')) {
            return [null, null];
        }

        $arquivo = $request->file('midia_publicacao');

        $extensao = strtolower(
            $arquivo->getClientOriginalExtension()
        );

        $nomeArquivo = time()
            . '_'
            . uniqid()
            . '.'
            . $extensao;

        $diretorio = public_path(
            'conexao360/uploads/publicacoes/'
        );

        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        $arquivo->move(
            $diretorio,
            $nomeArquivo
        );

        return [
            'IMAGEM',
            'uploads/publicacoes/' . $nomeArquivo,
        ];
    }
}
