<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conteudo;
use App\Models\Enquete;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConteudosController extends Controller
{
    public function index()
    {
        $totalVideos = Conteudo::where('tipo_conteudo', 'VIDEO')->count();

        $videosAtivos = Conteudo::where('tipo_conteudo', 'VIDEO')
            ->where('status_conteudo', 'ATIVO')
            ->count();

        $totalEnquetes = Enquete::count();

        return view('admin.conteudos.index', compact(
            'totalVideos',
            'videosAtivos',
            'totalEnquetes'
        ));
    }

    public function videos()
    {
        $eventos = Eventos::orderByDesc('data_inicial_evento')->get();

        $videos = Conteudo::with(['usuario', 'evento'])
            ->where('tipo_conteudo', 'VIDEO')
            ->orderByDesc('liberado_em_conteudo')
            ->orderByDesc('id_conteudos')
            ->get();

        return view('admin.conteudos.videos', compact(
            'eventos',
            'videos'
        ));
    }

    public function storeVideo(Request $request)
    {
        $dados = $request->validate([
            'id_evento' => 'required|integer|exists:tbl_eventos,id_evento',
            'titulo_conteudo' => 'required|string|max:150',
            'descricao_conteudo' => 'required|string|max:3000',
            'liberado_em_conteudo' => 'required|date',
            'url_conteudo' => 'required|url|max:255',
        ], [
            'id_evento.required' => 'Selecione o evento relacionado ao vídeo.',
            'titulo_conteudo.required' => 'Informe o título do vídeo.',
            'descricao_conteudo.required' => 'Informe uma descrição para o vídeo.',
            'liberado_em_conteudo.required' => 'Informe quando o vídeo ficará disponível.',
            'url_conteudo.required' => 'Informe a URL do vídeo.',
            'url_conteudo.url' => 'Informe uma URL válida para o vídeo.',
        ]);

        $usuario = Auth::guard('admin')->user();

        Conteudo::create([
            'id_usuario' => $usuario->id_usuario,
            'id_evento' => $dados['id_evento'],
            'titulo_conteudo' => $dados['titulo_conteudo'],
            'tipo_conteudo' => 'VIDEO',
            'descricao_conteudo' => $dados['descricao_conteudo'],
            'liberado_em_conteudo' => $dados['liberado_em_conteudo'],
            'url_conteudo' => $dados['url_conteudo'],
            'status_conteudo' => 'ATIVO',
        ]);

        return redirect()
            ->route('admin.conteudos.videos')
            ->with('success', 'Vídeo cadastrado com sucesso.');
    }

    public function statusVideo(Request $request, $id)
    {
        $dados = $request->validate([
            'status_conteudo' => 'required|in:ATIVO,INATIVO',
        ]);

        $video = Conteudo::where('tipo_conteudo', 'VIDEO')
            ->findOrFail($id);

        $video->update([
            'status_conteudo' => $dados['status_conteudo'],
        ]);

        $mensagem = $dados['status_conteudo'] === 'ATIVO'
            ? 'Vídeo ativado com sucesso.'
            : 'Vídeo inativado com sucesso.';

        return redirect()
            ->route('admin.conteudos.videos')
            ->with('success', $mensagem);
    }
}
