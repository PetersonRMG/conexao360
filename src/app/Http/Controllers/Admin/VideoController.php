
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    public function createVideo(Request $request)
    {
        $dados = $this->validarVideo($request, true);

        $caminhoVideo = $this->salvarArquivo(
            $request,
            'url_video'
        );

        $caminhoCapa = $this->salvarArquivo(
            $request,
            'capa_video'
        );

        $video = new Video();

        $video->id_evento = $dados['id_evento'];
        $video->titulo_video = $dados['titulo_video'];
        $video->subtitulo_video = $dados['subtitulo_video'];
        $video->legenda_video = $dados['legenda_video'];
        $video->breve_descricao_video =
            $dados['breve_descricao_video'];
        $video->status_video = $dados['status_video'];
        $video->url_video = $caminhoVideo;
        $video->capa_video = $caminhoCapa;

        $video->save();

        return redirect()
            ->route('admin.modificar.site')
            ->with('success', 'Vídeo vinculado ao evento com sucesso!');
    }

    public function updateVideo(Request $request, $id)
    {
        $dados = $this->validarVideo($request, false);

        $video = Video::findOrFail($id);

        $video->id_evento = $dados['id_evento'];
        $video->titulo_video = $dados['titulo_video'];
        $video->subtitulo_video = $dados['subtitulo_video'];
        $video->legenda_video = $dados['legenda_video'];
        $video->breve_descricao_video =
            $dados['breve_descricao_video'];
        $video->status_video = $dados['status_video'];

        if ($request->hasFile('url_video')) {
            $video->url_video = $this->salvarArquivo(
                $request,
                'url_video'
            );
        }

        if ($request->hasFile('capa_video')) {
            $video->capa_video = $this->salvarArquivo(
                $request,
                'capa_video'
            );
        }

        $video->save();

        return redirect()
            ->route('admin.modificar.site')
            ->with('success', 'Vídeo e evento atualizados com sucesso!');
    }

    private function validarVideo(
        Request $request,
        bool $criando
    ): array {
        return $request->validate([
            'id_evento' => [
                'required',
                'integer',
                Rule::exists('tbl_eventos', 'id_evento'),
            ],

            'titulo_video' => 'required|string|max:50',
            'subtitulo_video' => 'required|string|max:50',
            'legenda_video' => 'required|string|max:100',
            'breve_descricao_video' => 'required|string|max:80',
            'status_video' => 'required|in:ATIVO,INATIVO',

            'url_video' => [
                $criando ? 'required' : 'nullable',
                'file',
                'mimes:mp4,webm,mov',
                'max:51200',
            ],

            'capa_video' => [
                $criando ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'id_evento.required' =>
                'Selecione o evento relacionado ao vídeo.',
            'id_evento.exists' =>
                'O evento selecionado não existe.',
            'url_video.required' =>
                'Selecione o arquivo do vídeo.',
            'capa_video.required' =>
                'Selecione uma capa para o vídeo.',
        ]);
    }

    private function salvarArquivo(
        Request $request,
        string $campo
    ): ?string {
        if (!$request->hasFile($campo)) {
            return null;
        }

        $arquivo = $request->file($campo);

        $diretorio = public_path('conexao360/img/video');

        File::ensureDirectoryExists($diretorio);

        $nome = Str::uuid() . '.' .
            $arquivo->getClientOriginalExtension();

        $arquivo->move($diretorio, $nome);

        return 'video/' . $nome;
    }
}
