<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conteudo;
use App\Models\Eventos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class GaleriaEventoController extends Controller
{
    private function exigirAdministrador(Request $request): void
    {
        $perfil = strtolower(trim((string) ($request->user()?->perfil_usuario ?? '')));
        abort_unless($perfil === 'administrador', 403, 'Apenas o administrador publica conteúdos oficiais da galeria.');
    }

    public function index(Request $request, int $idEvento): JsonResponse
    {
        Eventos::query()->findOrFail($idEvento);

        $albuns = DB::table('tbl_albuns_evento')
            ->where('id_evento', $idEvento)
            ->where('status_album', 'ATIVO')
            ->orderByDesc('id_album')
            ->get()
            ->map(function ($album) {
                $fotos = DB::table('tbl_fotos_evento')
                    ->where('id_album', $album->id_album)
                    ->where('status_foto', 'ATIVO')
                    ->orderBy('id_foto')
                    ->get()
                    ->map(fn ($foto) => [
                        'id_foto' => $foto->id_foto,
                        'titulo_foto' => $foto->titulo_foto,
                        'descricao_foto' => $foto->descricao_foto,
                        'url_foto' => asset('conexao360/uploads/galeria/' . $foto->arquivo_foto),
                    ]);

                return [
                    'id_album' => $album->id_album,
                    'titulo_album' => $album->titulo_album,
                    'descricao_album' => $album->descricao_album,
                    'fotos' => $fotos,
                ];
            });

        $videosQuery = Conteudo::query()
            ->where('id_evento', $idEvento)
            ->whereRaw('UPPER(tipo_conteudo) = ?', ['VIDEO'])
            ->where('status_conteudo', 'ATIVO')
            ->where('liberado_em_conteudo', '<=', now());

        // Algumas máquinas ainda não aplicaram a migration de nível de acesso.
        // Nunca revelar conteúdos privados quando essa coluna estiver disponível.
        if (Schema::hasColumn('tbl_conteudos', 'nivel_acesso_conteudo')) {
            $videosQuery->where('nivel_acesso_conteudo', 'PUBLICO');
        }

        $videos = $videosQuery
            ->orderByDesc('id_conteudos')
            ->get(['id_conteudos', 'titulo_conteudo', 'descricao_conteudo', 'url_conteudo'])
            ->filter(fn ($video) => filter_var($video->url_conteudo, FILTER_VALIDATE_URL)
                && strtolower((string) parse_url($video->url_conteudo, PHP_URL_SCHEME)) === 'https')
            ->map(fn ($video) => [
                'id_conteudo' => $video->id_conteudos,
                'titulo_conteudo' => $video->titulo_conteudo,
                'descricao_conteudo' => $video->descricao_conteudo,
                'url_conteudo' => $video->url_conteudo,
            ])
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'id_evento' => $idEvento,
                'albuns' => $albuns,
                'videos' => $videos,
            ],
        ]);
    }

    public function criarAlbum(Request $request, int $idEvento): JsonResponse
    {
        $this->exigirAdministrador($request);
        Eventos::query()->findOrFail($idEvento);

        $dados = $request->validate([
            'titulo_album' => ['required', 'string', 'max:150'],
            'descricao_album' => ['nullable', 'string', 'max:2000'],
        ]);

        $idAlbum = DB::table('tbl_albuns_evento')->insertGetId([
            'id_evento' => $idEvento,
            'titulo_album' => $dados['titulo_album'],
            'descricao_album' => $dados['descricao_album'] ?? null,
            'status_album' => 'ATIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'data' => ['id_album' => $idAlbum]], 201);
    }

    public function enviarFoto(Request $request, int $idEvento, int $idAlbum): JsonResponse
    {
        $this->exigirAdministrador($request);
        Eventos::query()->findOrFail($idEvento);

        $album = DB::table('tbl_albuns_evento')
            ->where('id_evento', $idEvento)
            ->where('id_album', $idAlbum)
            ->where('status_album', 'ATIVO')
            ->first();
        abort_unless($album, 404, 'Álbum não encontrado neste evento.');

        $dados = $request->validate([
            'titulo_foto' => ['required', 'string', 'max:150'],
            'descricao_foto' => ['nullable', 'string', 'max:2000'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $arquivo = $request->file('foto');
        $nomeArquivo = (string) Str::uuid() . '.' . ($arquivo->guessExtension() ?: 'jpg');
        $pasta = public_path('conexao360/uploads/galeria');
        File::ensureDirectoryExists($pasta, 0755, true);
        $arquivo->move($pasta, $nomeArquivo);

        try {
            $idFoto = DB::table('tbl_fotos_evento')->insertGetId([
                'id_album' => $idAlbum,
                'titulo_foto' => $dados['titulo_foto'],
                'descricao_foto' => $dados['descricao_foto'] ?? null,
                'arquivo_foto' => $nomeArquivo,
                'status_foto' => 'ATIVO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            File::delete($pasta . DIRECTORY_SEPARATOR . $nomeArquivo);
            throw $e;
        }

        return response()->json(['success' => true, 'data' => [
            'id_foto' => $idFoto,
            'url_foto' => asset('conexao360/uploads/galeria/' . $nomeArquivo),
        ]], 201);
    }

    public function cadastrarVideo(Request $request, int $idEvento): JsonResponse
    {
        $this->exigirAdministrador($request);
        Eventos::query()->findOrFail($idEvento);

        $dados = $request->validate([
            'titulo_conteudo' => ['required', 'string', 'max:150'],
            'descricao_conteudo' => ['nullable', 'string', 'max:2000'],
            'url_conteudo' => ['required', 'url', 'starts_with:https://', 'max:255'],
        ]);

        $host = strtolower((string) parse_url($dados['url_conteudo'], PHP_URL_HOST));
        $hostsAceitos = ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be',
            'instagram.com', 'www.instagram.com', 'vimeo.com', 'www.vimeo.com', 'player.vimeo.com'];
        if (!in_array($host, $hostsAceitos, true)) {
            throw ValidationException::withMessages(['url_conteudo' => 'Use um link HTTPS do YouTube, Instagram ou Vimeo.']);
        }

        $atributos = [
            'id_usuario' => $request->user()->id_usuario,
            'id_evento' => $idEvento,
            'titulo_conteudo' => $dados['titulo_conteudo'],
            'descricao_conteudo' => $dados['descricao_conteudo'] ?? '',
            'tipo_conteudo' => 'VIDEO',
            'url_conteudo' => $dados['url_conteudo'],
            'liberado_em_conteudo' => now(),
            'status_conteudo' => 'ATIVO',
        ];
        if (Schema::hasColumn('tbl_conteudos', 'nivel_acesso_conteudo')) {
            $atributos['nivel_acesso_conteudo'] = 'PUBLICO';
        }

        $conteudo = Conteudo::query()->create($atributos);
        return response()->json(['success' => true, 'data' => [
            'id_conteudo' => $conteudo->id_conteudos,
            'id_evento' => $idEvento,
        ]], 201);
    }
}
