
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use App\Models\Conteudo;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    public function index(): JsonResponse
    {
        $eventos = Eventos::query()
            ->select([
                'id_evento',
                'titulo_evento',
                'edicao_evento',
                'descricao_evento',
                'data_inicial_evento',
                'hora_inicial_evento',
                'data_termino_evento',
                'hora_termino_evento',
                'endereco_evento',
                'banner_evento',
            ])
            ->whereIn('status_evento', ['ATIVO', 'INATIVO'])
            ->orderByDesc('data_inicial_evento')
            ->orderByDesc('hora_inicial_evento')
            ->get()
            ->map(function (Eventos $evento): array {
                return [
                    'id_evento' => $evento->id_evento,
                    'titulo_evento' => $evento->titulo_evento,
                    'edicao_evento' => $evento->edicao_evento,
                    'descricao_evento' => $evento->descricao_evento,
                    'data_inicial_evento' =>
                        $evento->data_inicial_evento,
                    'hora_inicial_evento' =>
                        $evento->hora_inicial_evento,
                    'data_termino_evento' =>
                        $evento->data_termino_evento,
                    'hora_termino_evento' =>
                        $evento->hora_termino_evento,
                    'endereco_evento' =>
                        $evento->endereco_evento,
                    'banner_url' => $this->urlImagem(
                        $evento->banner_evento
                    ),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $eventos,
        ]);
    }

    public function galeria(int $id): JsonResponse
    {
        $evento = Eventos::query()
            ->whereIn('status_evento', ['ATIVO', 'INATIVO'])
            ->findOrFail($id);

        // Vídeos enviados diretamente pelo dashboard.
        $videosSite = Video::query()
            ->where('id_evento', $evento->id_evento)
            ->where('status_video', 'ATIVO')
            ->get()
            ->map(function (Video $video): array {
                return [
                    'id' => $video->id_video,
                    'origem' => 'SITE',
                    'titulo' => $video->titulo_video,
                    'descricao' =>
                        $video->breve_descricao_video,
                    'url' => $this->urlImagem(
                        $video->url_video
                    ),
                    'capa_url' => $this->urlImagem(
                        $video->capa_video
                    ),
                ];
            });

        // Vídeos das palestras publicados por URL.
        $videosPalestras = Conteudo::query()
            ->where('id_evento', $evento->id_evento)
            ->where('tipo_conteudo', 'VIDEO')
            ->where('status_conteudo', 'ATIVO')
            ->where('nivel_acesso_conteudo', 'PUBLICO')
            ->where('liberado_em_conteudo', '<=', now())
            ->get()
            ->map(function (Conteudo $conteudo): array {
                return [
                    'id' => $conteudo->id_conteudos,
                    'origem' => 'PALESTRA',
                    'titulo' => $conteudo->titulo_conteudo,
                    'descricao' =>
                        $conteudo->descricao_conteudo,
                    'url' => $conteudo->url_conteudo,
                    'capa_url' => null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'evento' => [
                    'id_evento' => $evento->id_evento,
                    'titulo_evento' => $evento->titulo_evento,
                    'edicao_evento' => $evento->edicao_evento,
                    'descricao_evento' =>
                        $evento->descricao_evento,
                    'banner_url' => $this->urlImagem(
                        $evento->banner_evento
                    ),
                ],

                // A galeria oficial de fotos será
                // ligada após criarmos o cadastro no painel.
                'fotos' => [],

                'videos' => $videosSite
                    ->concat($videosPalestras)
                    ->values(),
            ],
        ]);
    }

    private function urlImagem(?string $caminho): ?string
    {
        $caminho = trim((string) $caminho);

        $caminho = preg_replace(
            '#^/?conexao360/img/#',
            '',
            $caminho
        );

        $caminho = ltrim($caminho, '/');

        return $caminho !== ''
            ? asset('conexao360/img/' . $caminho)
            : null;
    }
}
