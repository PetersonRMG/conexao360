<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Publicacao;
use App\Models\Eventos;

class PublicacaoController extends Controller
{
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
        $request->validate([
            'texto_publicacao' => 'nullable|required_without:midia_publicacao|string|max:5000',

            'id_evento' => 'nullable|exists:tbl_eventos,id_evento',

            'midia_publicacao' => [
                'nullable',
                'required_without:texto_publicacao',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,mov',
                'max:20480',
            ],
        ]);

        $usuario = Auth::guard('admin')->user();

        $tipoMidia = null;
        $caminhoMidia = null;

        if ($request->hasFile('midia_publicacao')) {

            $arquivo = $request->file('midia_publicacao');

            $extensao = strtolower(
                $arquivo->getClientOriginalExtension()
            );

            $extensoesImagem = [
                'jpg',
                'jpeg',
                'png',
                'webp',
            ];

            if (in_array($extensao, $extensoesImagem)) {
                $tipoMidia = 'IMAGEM';
            } else {
                $tipoMidia = 'VIDEO';
            }

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

            $caminhoMidia = 'uploads/publicacoes/'
                . $nomeArquivo;
        }

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
}