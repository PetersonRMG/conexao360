<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EventoController extends Controller
{
    public function index(Request $request): View
    {
        $busca = trim((string) $request->query('busca', ''));
        $status = (string) $request->query('status', '');

        $eventos = Eventos::query()
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($query) use ($busca) {
                    $query->where('titulo_evento', 'like', '%' . $busca . '%')
                        ->orWhere('edicao_evento', 'like', '%' . $busca . '%')
                        ->orWhere('endereco_evento', 'like', '%' . $busca . '%');
                });
            })
            ->when(in_array($status, ['ATIVO', 'INATIVO'], true),
                fn ($query) => $query->where('status_evento', $status))
            ->orderByRaw("CASE WHEN status_evento = 'ATIVO' THEN 0 ELSE 1 END")
            ->orderByDesc('data_inicial_evento')
            ->paginate(10)
            ->withQueryString();

        $contagens = [];
        foreach ([
            'videos' => ['tbl_conteudos', 'tipo_conteudo', 'VIDEO'],
            'enquetes' => ['tbl_enquetes', null, null],
            'albuns' => ['tbl_albuns_evento', null, null],
            'programacao' => ['tbl_programacao_evento', null, null],
        ] as $chave => [$tabela, $coluna, $valor]) {
            if (!Schema::hasTable($tabela) || !Schema::hasColumn($tabela, 'id_evento')) {
                $contagens[$chave] = collect();
                continue;
            }
            $consulta = DB::table($tabela)->select('id_evento')
                ->selectRaw('COUNT(*) as total')->groupBy('id_evento');
            if ($coluna !== null) {
                $consulta->where($coluna, $valor);
            }
            $contagens[$chave] = $consulta->pluck('total', 'id_evento');
        }

        // Inclui os arquivos de vídeo antigos do site na contagem de vídeos do evento.
        if (Schema::hasTable('tbl_videos') && Schema::hasColumn('tbl_videos', 'id_evento')) {
            $videosAntigos = DB::table('tbl_videos')
                ->select('id_evento')->selectRaw('COUNT(*) as total')
                ->groupBy('id_evento')->pluck('total', 'id_evento');
            foreach ($videosAntigos as $idEvento => $total) {
                $contagens['videos']->put($idEvento,
                    (int) $contagens['videos']->get($idEvento, 0) + (int) $total);
            }
        }

        return view('admin.eventos.gerenciar', [
            'eventos' => $eventos,
            'busca' => $busca,
            'status' => $status,
            'contagens' => $contagens,
            'totalEventos' => Eventos::count(),
            'totalAtivos' => Eventos::where('status_evento', 'ATIVO')->count(),
        ]);
    }

    public function novo(): View
    {
        return view('admin.eventos.formulario', ['eventoEditando' => null]);
    }

    public function editar(int $idEvento): View
    {
        return view('admin.eventos.formulario', [
            'eventoEditando' => Eventos::findOrFail($idEvento),
        ]);
    }

    public function createEvento(Request $request)
    {
        $dados = $this->validar($request, true);
        $dados['banner_evento'] = $this->salvarBanner($request);

        $evento = DB::transaction(function () use ($dados) {
            if ($dados['status_evento'] === 'ATIVO') {
                Eventos::where('status_evento', 'ATIVO')->update(['status_evento' => 'INATIVO']);
            }
            return Eventos::create($dados);
        });

        return redirect()->route('admin.eventos.editar', ['idEvento' => $evento->id_evento])
            ->with('success', 'Evento criado com sucesso. Agora você pode gerenciar o conteúdo.');
    }

    public function updateEvento(Request $request, int $id)
    {
        $evento = Eventos::findOrFail($id);
        $dados = $this->validar($request, false, $evento);
        if ($request->hasFile('banner_evento')) {
            $dados['banner_evento'] = $this->salvarBanner($request);
        }

        DB::transaction(function () use ($evento, $dados) {
            if ($dados['status_evento'] === 'ATIVO') {
                Eventos::where('id_evento', '!=', $evento->id_evento)
                    ->where('status_evento', 'ATIVO')
                    ->update(['status_evento' => 'INATIVO']);
            }
            $evento->update($dados);
        });

        return redirect()->route('admin.eventos.editar', ['idEvento' => $evento->id_evento])
            ->with('success', 'Dados do evento atualizados com sucesso.');
    }

    private function validar(Request $request, bool $criando, ?Eventos $eventoExistente = null): array
    {
        $dados = $request->validate([
            // Ao editar, o upload é opcional: sem novo arquivo, preservamos o banner atual.
            'banner_evento' => [$criando ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'titulo_evento' => 'required|string|max:200',
            'edicao_evento' => 'required|integer|min:1',
            'descricao_evento' => 'required|string',
            'data_inicial_evento' => 'required|date',
            'hora_inicial_evento' => 'required|date_format:H:i',
            'data_termino_evento' => 'required|date|after_or_equal:data_inicial_evento',
            'hora_termino_evento' => 'required|date_format:H:i',
            'endereco_evento' => 'required|string|max:80',
            // Este campo já alimenta o iframe do mapa na página pública.
            'url_evento' => 'nullable|string|max:2000',
            'status_evento' => 'required|in:ATIVO,INATIVO',
        ], [
            'banner_evento.required' => 'Selecione a imagem do banner para cadastrar o evento.',
            'banner_evento.uploaded' => 'Não foi possível receber a imagem. Confira o limite de upload do servidor (2 MB).',
            'banner_evento.image' => 'O banner precisa ser uma imagem válida.',
            'banner_evento.mimes' => 'Envie uma imagem JPG, PNG ou WebP.',
            'banner_evento.max' => 'O banner pode ter no máximo 2 MB.',
            'edicao_evento.integer' => 'A edição deve ser um número.',
        ]);

        // Preserva mapas legados quando o usuário só deseja atualizar o banner.
        // Novos valores são normalizados para guardar apenas o src do iframe.
        $mapaInformado = $dados['url_evento'] ?? null;
        if ($eventoExistente && $mapaInformado === $eventoExistente->url_evento) {
            $dados['url_evento'] = $eventoExistente->url_evento;
        } else {
            $dados['url_evento'] = $this->normalizarMapa($mapaInformado);
        }

        return $dados;
    }

    private function salvarBanner(Request $request): string
    {
        $arquivo = $request->file('banner_evento');

        if (!$arquivo || !$arquivo->isValid()) {
            throw ValidationException::withMessages([
                'banner_evento' => 'Não foi possível receber o banner. Tente novamente com uma imagem de até 2 MB.',
            ]);
        }

        // Mantém o diretório público usado nas páginas existentes e na API.
        $diretorio = public_path('conexao360/img/evento');

        try {
            File::ensureDirectoryExists($diretorio, 0775, true);

            if (!is_writable($diretorio)) {
                throw new \RuntimeException('Diretório de banners sem permissão de escrita.');
            }

            $nome = Str::uuid() . '.' . $arquivo->extension();
            $arquivo->move($diretorio, $nome);

            return 'evento/' . $nome;
        } catch (\Throwable $excecao) {
            report($excecao);
            throw ValidationException::withMessages([
                'banner_evento' => 'Não foi possível salvar o banner. Verifique as permissões de escrita de public/conexao360/img/evento.',
            ]);
        }
    }

    private function normalizarMapa(?string $valor): ?string
    {
        $valor = trim((string) $valor);
        if ($valor === '') {
            return null;
        }

        // Aceita o código de incorporação do Google Maps e extrai apenas seu src.
        if (stripos($valor, '<iframe') !== false) {
            if (!preg_match('~<iframe\b[^>]*\bsrc\s*=\s*(["\'])(.*?)\1~is', $valor, $captura)) {
                throw ValidationException::withMessages([
                    'url_evento' => 'O iframe do mapa não possui um endereço src válido.',
                ]);
            }
            $valor = $captura[2];
        }

        $valor = trim(html_entity_decode($valor, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $host = strtolower((string) parse_url($valor, PHP_URL_HOST));
        $esquema = strtolower((string) parse_url($valor, PHP_URL_SCHEME));

        // URLs públicas e seguras de mapas incorporáveis (não links comuns de compartilhamento).
        $google = preg_match('~^(?:(?:www|maps)\.)?google\.(?:com(?:\.[a-z]{2})?|co\.[a-z]{2}|[a-z]{2})$~', $host) === 1
            && str_contains((string) parse_url($valor, PHP_URL_PATH), '/maps');
        $openStreetMap = in_array($host, ['openstreetmap.org', 'www.openstreetmap.org'], true)
            && str_contains((string) parse_url($valor, PHP_URL_PATH), '/export/embed.html');

        if (!filter_var($valor, FILTER_VALIDATE_URL) || $esquema !== 'https' || (!$google && !$openStreetMap)) {
            throw ValidationException::withMessages([
                'url_evento' => 'Cole o iframe do Google Maps ou a URL HTTPS de incorporação do mapa (não o link de compartilhamento).',
            ]);
        }

        if (mb_strlen($valor) > 2000) {
            throw ValidationException::withMessages([
                'url_evento' => 'O endereço do mapa ultrapassa 2.000 caracteres.',
            ]);
        }

        return $valor;
    }
}
