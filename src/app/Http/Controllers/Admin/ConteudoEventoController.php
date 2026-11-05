<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use App\Models\Video;
use App\Models\Conteudo;
use App\Models\Enquete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Central de conteudo de um evento (acesso restrito ao administrador por routes/web.php).
 * Nao modifica os formularios atuais de Modificacoes do Site, Videos ou Enquetes.
 */
class ConteudoEventoController extends Controller
{
    public function show(int $idEvento): View
    {
        $evento = Eventos::query()->findOrFail($idEvento);
        $videosSite = Schema::hasTable('tbl_videos') && Schema::hasColumn('tbl_videos', 'id_evento')
            ? Video::where('id_evento', $idEvento)->orderByDesc('id_video')->get()
            : collect();

        $galeriaDisponivel = Schema::hasTable('tbl_albuns_evento')
            && Schema::hasTable('tbl_fotos_evento');
        $albuns = collect();
        $totalFotos = 0;

        if ($galeriaDisponivel) {
            $albuns = DB::table('tbl_albuns_evento')
                ->where('id_evento', $idEvento)
                ->orderByDesc('id_album')
                ->get();

            $fotosPorAlbum = DB::table('tbl_fotos_evento')
                ->whereIn('id_album', $albuns->pluck('id_album'))
                ->orderByDesc('id_foto')
                ->get()
                ->groupBy('id_album');

            foreach ($albuns as $album) {
                $album->fotos = $fotosPorAlbum->get($album->id_album, collect());
                $totalFotos += $album->fotos->count();
            }
        }

        $videosDisponiveis = Schema::hasTable('tbl_conteudos')
            && Schema::hasColumn('tbl_conteudos', 'id_evento')
            && Schema::hasColumn('tbl_conteudos', 'tipo_conteudo');

        $videos = $videosDisponiveis
            ? DB::table('tbl_conteudos')
                ->where('id_evento', $idEvento)
                ->whereRaw('UPPER(tipo_conteudo) = ?', ['VIDEO'])
                ->orderByDesc('id_conteudos')
                ->get()
            : collect();

        // Somente mostrar enquetes do evento quando o banco possuir o vinculo.
        $enquetesVinculadas = Schema::hasTable('tbl_enquetes')
            && Schema::hasColumn('tbl_enquetes', 'id_evento');

        $enquetes = $enquetesVinculadas
            ? DB::table('tbl_enquetes')
                ->where('id_evento', $idEvento)
                ->orderByDesc('id_enquete')
                ->get()
            : collect();

        // Resultados das enquetes do evento (preserva os votos existentes).
        $votos = Schema::hasTable('tbl_respostas')
            ? DB::table('tbl_respostas')
                ->whereIn('id_enquete', $enquetes->pluck('id_enquete'))
                ->select('id_enquete', 'resposta_resposta')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('id_enquete', 'resposta_resposta')
                ->get()->groupBy('id_enquete')
            : collect();
        foreach ($enquetes as $enquete) {
            $respostas = $votos->get($enquete->id_enquete, collect());
            $enquete->votos_sim = (int) optional($respostas->firstWhere('resposta_resposta', 1))->total;
            $enquete->votos_nao = (int) optional($respostas->firstWhere('resposta_resposta', 2))->total;
            $enquete->votos_outro = (int) optional($respostas->firstWhere('resposta_resposta', 3))->total;
            $enquete->total_votos = $enquete->votos_sim + $enquete->votos_nao + $enquete->votos_outro;
        }

        // Enquetes antigas continuam globais; o administrador pode associá-las manualmente.
        $enquetesSemEvento = $enquetesVinculadas
            ? DB::table('tbl_enquetes')
                ->whereNull('id_evento')
                ->orderByDesc('id_enquete')
                ->limit(200)
                ->get(['id_enquete', 'pergunta_enquete'])
            : collect();

        $programacaoDisponivel = Schema::hasTable('tbl_programacao_evento');
        $palestrantesDisponiveis = $programacaoDisponivel
            && Schema::hasTable('tbl_usuarios')
            && Schema::hasColumn('tbl_programacao_evento', 'id_palestrante');

        $consultaProgramacao = DB::table('tbl_programacao_evento');
        if ($palestrantesDisponiveis) {
            $consultaProgramacao->leftJoin('tbl_usuarios as palestrante_cadastrado',
                'palestrante_cadastrado.id_usuario', '=', 'tbl_programacao_evento.id_palestrante')
                ->select('tbl_programacao_evento.*', 'palestrante_cadastrado.nome_usuario as nome_palestrante_cadastrado');
        }

        $programacao = $programacaoDisponivel
            ? $consultaProgramacao
                ->where('tbl_programacao_evento.id_evento', $idEvento)
                ->orderBy('tbl_programacao_evento.inicio_programacao')
                ->orderBy('tbl_programacao_evento.id_programacao')
                ->get()
            : collect();

        // Apresenta palestrantes ativos; mantém disponíveis os já vinculados
        // a atividades deste evento, mesmo quando foram inativados depois.
        $palestrantes = collect();
        if ($palestrantesDisponiveis) {
            $selecionados = $programacao->pluck('id_palestrante')->filter()->unique()->values()->all();
            $palestrantes = DB::table('tbl_usuarios')
                ->where('perfil_usuario', 'palestrante')
                ->where(function ($query) use ($selecionados) {
                    $query->where('status_usuario', 'ATIVO');
                    if ($selecionados !== []) {
                        $query->orWhereIn('id_usuario', $selecionados);
                    }
                })
                ->orderBy('nome_usuario')
                ->get(['id_usuario', 'nome_usuario', 'area_atuacao_usuario', 'status_usuario']);
        }

        return view('admin.eventos.index', compact(
            'evento', 'videosSite', 'galeriaDisponivel', 'albuns', 'totalFotos',
            'videosDisponiveis', 'videos', 'enquetesVinculadas', 'enquetes',
            'programacaoDisponivel', 'programacao', 'enquetesSemEvento',
            'palestrantesDisponiveis', 'palestrantes'
        ));
    }

    public function criarAlbum(Request $request, int $idEvento): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();

        $urlGaleria = route('admin.eventos.conteudo', ['idEvento' => $idEvento]) . '#fotos';
        $validador = Validator::make($request->all(), [
            'titulo_album' => ['required', 'string', 'max:150'],
            'descricao_album' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($validador->fails()) {
            return redirect()->to($urlGaleria)
                ->withErrors($validador, 'album')
                ->withInput();
        }

        $dados = $validador->validated();

        try {
            DB::table('tbl_albuns_evento')->insert([
                'id_evento' => $idEvento,
                'titulo_album' => $dados['titulo_album'],
                'descricao_album' => $dados['descricao_album'] ?? null,
                'status_album' => 'ATIVO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $erro) {
            Log::error('Falha ao criar álbum de evento.', [
                'id_evento' => $idEvento,
                'exception' => $erro,
            ]);

            return redirect()->to($urlGaleria)
                ->withInput()
                ->with('album_error', 'Não foi possível criar o álbum. Verifique o log do Laravel ou solicite apoio ao administrador.');
        }

        return redirect()->to($urlGaleria)
            ->with('success', 'Álbum criado com sucesso.');
    }

    public function enviarFoto(Request $request, int $idEvento, int $idAlbum): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();

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

        $arquivo = $dados['foto'];
        $nomeArquivo = (string) Str::uuid() . '.' . ($arquivo->guessExtension() ?: 'jpg');
        $pasta = public_path('conexao360/uploads/galeria');
        File::ensureDirectoryExists($pasta, 0755, true);
        $arquivo->move($pasta, $nomeArquivo);

        try {
            DB::table('tbl_fotos_evento')->insert([
                'id_album' => $idAlbum,
                'titulo_foto' => $dados['titulo_foto'],
                'descricao_foto' => $dados['descricao_foto'] ?? null,
                'arquivo_foto' => $nomeArquivo,
                'status_foto' => 'ATIVO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $erro) {
            File::delete($pasta . DIRECTORY_SEPARATOR . $nomeArquivo);
            throw $erro;
        }

        return redirect()->route('admin.eventos.conteudo', ['idEvento' => $idEvento])
            ->with('success', 'Foto adicionada ao álbum.');
    }

    /** Atualiza o álbum, sempre limitado ao evento informado na rota. */
    public function atualizarAlbum(Request $request, int $idEvento, int $idAlbum): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();
        $album = DB::table('tbl_albuns_evento')->where('id_evento', $idEvento)
            ->where('id_album', $idAlbum)->first();
        abort_unless($album, 404, 'Álbum não encontrado neste evento.');

        $dados = $request->validate([
            'titulo_album' => ['required', 'string', 'max:150'],
            'descricao_album' => ['nullable', 'string', 'max:2000'],
            'status_album' => ['required', Rule::in(['ATIVO', 'INATIVO'])],
        ]);
        DB::table('tbl_albuns_evento')->where('id_album', $idAlbum)
            ->where('id_evento', $idEvento)
            ->update([...$dados, 'updated_at' => now()]);
        return $this->voltarAoEvento($idEvento, 'fotos', 'Álbum atualizado.');
    }

    /** A exclusão de um álbum com fotos não é automática para evitar perda acidental. */
    public function excluirAlbum(int $idEvento, int $idAlbum): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();
        $album = DB::table('tbl_albuns_evento')->where('id_evento', $idEvento)
            ->where('id_album', $idAlbum)->first();
        abort_unless($album, 404, 'Álbum não encontrado neste evento.');
        if (DB::table('tbl_fotos_evento')->where('id_album', $idAlbum)->exists()) {
            return $this->voltarAoEvento($idEvento, 'fotos', 'Exclua as fotos antes de excluir o álbum.');
        }
        DB::table('tbl_albuns_evento')->where('id_evento', $idEvento)
            ->where('id_album', $idAlbum)->delete();
        return $this->voltarAoEvento($idEvento, 'fotos', 'Álbum vazio excluído.');
    }

    /** Edita título, descrição, visibilidade e, opcionalmente, substitui a imagem. */
    public function atualizarFoto(Request $request, int $idEvento, int $idAlbum, int $idFoto): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();
        $this->albumDoEvento($idEvento, $idAlbum);
        $foto = DB::table('tbl_fotos_evento')->where('id_album', $idAlbum)
            ->where('id_foto', $idFoto)->first();
        abort_unless($foto, 404, 'Foto não encontrada neste álbum.');

        $dados = $request->validate([
            'titulo_foto' => ['required', 'string', 'max:150'],
            'descricao_foto' => ['nullable', 'string', 'max:2000'],
            'status_foto' => ['required', Rule::in(['ATIVO', 'INATIVO'])],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $arquivo = $dados['foto'] ?? null;
        unset($dados['foto']);
        $novoCaminho = null;
        if ($arquivo) {
            $pasta = public_path('conexao360/uploads/galeria');
            File::ensureDirectoryExists($pasta, 0755, true);
            $novoNome = (string) Str::uuid() . '.' . ($arquivo->guessExtension() ?: 'jpg');
            $arquivo->move($pasta, $novoNome);
            $novoCaminho = $pasta . DIRECTORY_SEPARATOR . $novoNome;
            $dados['arquivo_foto'] = $novoNome;
        }
        try {
            DB::table('tbl_fotos_evento')->where('id_album', $idAlbum)
                ->where('id_foto', $idFoto)
                ->update([...$dados, 'updated_at' => now()]);
        } catch (\Throwable $erro) {
            if ($novoCaminho) File::delete($novoCaminho);
            throw $erro;
        }
        if ($novoCaminho) $this->removerArquivoFoto((string) $foto->arquivo_foto);
        return $this->voltarAoEvento($idEvento, 'fotos', 'Foto atualizada com sucesso.');
    }

    public function excluirFoto(int $idEvento, int $idAlbum, int $idFoto): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirTabelasGaleria();
        $this->albumDoEvento($idEvento, $idAlbum);
        $foto = DB::table('tbl_fotos_evento')->where('id_album', $idAlbum)
            ->where('id_foto', $idFoto)->first();
        abort_unless($foto, 404, 'Foto não encontrada neste álbum.');

        DB::table('tbl_fotos_evento')->where('id_album', $idAlbum)
            ->where('id_foto', $idFoto)->delete();
        $this->removerArquivoFoto((string) $foto->arquivo_foto);
        return $this->voltarAoEvento($idEvento, 'fotos', 'Foto excluída do álbum.');
    }

    private function albumDoEvento(int $idEvento, int $idAlbum): object
    {
        $album = DB::table('tbl_albuns_evento')->where('id_evento', $idEvento)
            ->where('id_album', $idAlbum)->first();
        abort_unless($album, 404, 'Álbum não encontrado neste evento.');
        return $album;
    }

    private function removerArquivoFoto(string $nome): void
    {
        // Apenas arquivos do diretório da galeria podem ser removidos.
        if ($nome !== '' && basename($nome) === $nome) {
            File::delete(public_path('conexao360/uploads/galeria/' . $nome));
        }
    }

    /** Cadastra vídeo da edição, reaproveitando tbl_conteudos e o padrão de URLs externas. */
    public function criarVideo(Request $request, int $idEvento): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirVideos();

        $dados = $request->validate([
            'titulo_conteudo' => ['required', 'string', 'max:150'],
            'descricao_conteudo' => ['required', 'string', 'max:3000'],
            'url_conteudo' => ['required', 'url', 'starts_with:https://', 'max:255'],
            'liberado_em_conteudo' => ['required', 'date'],
        ]);

        $usuario = Auth::guard('admin')->user();

        Conteudo::create([
            'id_usuario' => $usuario->id_usuario,
            'id_evento' => $idEvento,
            'titulo_conteudo' => $dados['titulo_conteudo'],
            'tipo_conteudo' => 'VIDEO',
            'nivel_acesso_conteudo' => 'PUBLICO',
            'descricao_conteudo' => $dados['descricao_conteudo'],
            'liberado_em_conteudo' => $dados['liberado_em_conteudo'],
            'url_conteudo' => $dados['url_conteudo'],
            'status_conteudo' => 'ATIVO',
        ]);

        return $this->voltarAoEvento($idEvento, 'videos', 'Vídeo vinculado ao evento com sucesso.');
    }

    public function atualizarVideo(Request $request, int $idEvento, int $idVideo): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirVideos();
        $video = Conteudo::query()->where('id_evento', $idEvento)
            ->where('tipo_conteudo', 'VIDEO')->where('id_conteudos', $idVideo)->firstOrFail();
        $dados = $request->validate([
            'titulo_conteudo' => ['required', 'string', 'max:150'],
            'descricao_conteudo' => ['required', 'string', 'max:3000'],
            'url_conteudo' => ['required', 'url', 'starts_with:https://', 'max:255'],
            'liberado_em_conteudo' => ['required', 'date'],
        ]);
        $video->update($dados);
        return $this->voltarAoEvento($idEvento, 'videos', 'Vídeo atualizado.');
    }

    public function excluirVideo(int $idEvento, int $idVideo): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirVideos();
        Conteudo::query()->where('id_evento', $idEvento)
            ->where('tipo_conteudo', 'VIDEO')->where('id_conteudos', $idVideo)
            ->firstOrFail()->delete();
        return $this->voltarAoEvento($idEvento, 'videos', 'Vídeo excluído do evento.');
    }

    public function alterarStatusVideo(Request $request, int $idEvento, int $idVideo): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $dados = $request->validate(['status_conteudo' => ['required', Rule::in(['ATIVO', 'INATIVO'])]]);

        Conteudo::query()
            ->where('id_evento', $idEvento)
            ->where('tipo_conteudo', 'VIDEO')
            ->where('id_conteudos', $idVideo)
            ->firstOrFail()
            ->update(['status_conteudo' => $dados['status_conteudo']]);

        return $this->voltarAoEvento($idEvento, 'videos', 'Status do vídeo atualizado.');
    }

    public function criarEnquete(Request $request, int $idEvento): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirEnquetesVinculadas();
        $dados = $request->validate([
            'pergunta_enquete' => ['required', 'string', 'max:80'],
        ]);
        $usuario = Auth::guard('admin')->user();

        Enquete::create([
            'id_usuario' => $usuario->id_usuario,
            'id_evento' => $idEvento,
            'pergunta_enquete' => $dados['pergunta_enquete'],
            'status_enquete' => 'ATIVA',
        ]);

        return $this->voltarAoEvento($idEvento, 'enquetes', 'Enquete vinculada ao evento com sucesso.');
    }

    public function atualizarEnquete(Request $request, int $idEvento, int $idEnquete): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirEnquetesVinculadas();
        $enquete = DB::table('tbl_enquetes')->where('id_evento', $idEvento)
            ->where('id_enquete', $idEnquete)->first();
        abort_unless($enquete, 404, 'Enquete não encontrada neste evento.');
        if (DB::table('tbl_respostas')->where('id_enquete', $idEnquete)->exists()) {
            throw ValidationException::withMessages([
                'pergunta_enquete' => 'A pergunta não pode mudar após receber votos. Encerre-a e crie outra enquete.',
            ]);
        }
        $dados = $request->validate(['pergunta_enquete' => ['required', 'string', 'max:80']]);
        DB::table('tbl_enquetes')->where('id_evento', $idEvento)
            ->where('id_enquete', $idEnquete)
            ->update([...$dados, 'atualizado_em_enquete' => now()]);
        return $this->voltarAoEvento($idEvento, 'enquetes', 'Enquete atualizada.');
    }

    public function excluirEnquete(int $idEvento, int $idEnquete): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirEnquetesVinculadas();
        $enquete = DB::table('tbl_enquetes')->where('id_evento', $idEvento)
            ->where('id_enquete', $idEnquete)->first();
        abort_unless($enquete, 404, 'Enquete não encontrada neste evento.');
        if (DB::table('tbl_respostas')->where('id_enquete', $idEnquete)->exists()) {
            throw ValidationException::withMessages([
                'id_enquete' => 'Não é possível excluir uma enquete que já recebeu votos. Encerre-a para preservar as respostas.',
            ]);
        }
        DB::table('tbl_enquetes')->where('id_evento', $idEvento)
            ->where('id_enquete', $idEnquete)->delete();
        return $this->voltarAoEvento($idEvento, 'enquetes', 'Enquete sem votos excluída.');
    }

    public function vincularEnquete(Request $request, int $idEvento): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirEnquetesVinculadas();
        $dados = $request->validate([
            'id_enquete' => ['required', 'integer', Rule::exists('tbl_enquetes', 'id_enquete')],
        ]);

        // Não transfere enquete de outra edição e não altera as respostas existentes.
        $atualizadas = DB::table('tbl_enquetes')
            ->where('id_enquete', $dados['id_enquete'])
            ->whereNull('id_evento')
            ->update(['id_evento' => $idEvento, 'atualizado_em_enquete' => now()]);

        if ($atualizadas !== 1) {
            throw ValidationException::withMessages([
                'id_enquete' => 'Esta enquete já está vinculada a outro evento.',
            ]);
        }

        return $this->voltarAoEvento($idEvento, 'enquetes', 'Enquete existente vinculada ao evento.');
    }

    public function alterarStatusEnquete(Request $request, int $idEvento, int $idEnquete): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirEnquetesVinculadas();
        $dados = $request->validate(['status_enquete' => ['required', Rule::in(['ATIVA', 'ENCERRADA'])]]);

        Enquete::query()
            ->where('id_evento', $idEvento)
            ->where('id_enquete', $idEnquete)
            ->firstOrFail()
            ->update(['status_enquete' => $dados['status_enquete']]);

        return $this->voltarAoEvento($idEvento, 'enquetes', 'Status da enquete atualizado.');
    }

    public function criarProgramacao(Request $request, int $idEvento): RedirectResponse
    {
        $evento = Eventos::query()->findOrFail($idEvento);
        $this->exigirProgramacao();
        $dados = $this->validarProgramacao($request, $evento);

        DB::table('tbl_programacao_evento')->insert([
            'id_evento' => $idEvento,
            ...$dados,
            'status_programacao' => 'ATIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $this->voltarAoEvento($idEvento, 'programacao', 'Atividade adicionada à programação.');
    }

    public function atualizarProgramacao(Request $request, int $idEvento, int $idProgramacao): RedirectResponse
    {
        $evento = Eventos::query()->findOrFail($idEvento);
        $this->exigirProgramacao();
        $atividade = DB::table('tbl_programacao_evento')
            ->where('id_evento', $idEvento)
            ->where('id_programacao', $idProgramacao)
            ->first();
        abort_unless($atividade, 404, 'Atividade não encontrada neste evento.');

        $dados = $this->validarProgramacao($request, $evento, $atividade->id_palestrante ?? null);
        DB::table('tbl_programacao_evento')
            ->where('id_evento', $idEvento)
            ->where('id_programacao', $idProgramacao)
            ->update([...$dados, 'updated_at' => now()]);

        return $this->voltarAoEvento($idEvento, 'programacao', 'Atividade atualizada com sucesso.');
    }

    public function alterarStatusProgramacao(Request $request, int $idEvento, int $idProgramacao): RedirectResponse
    {
        Eventos::query()->findOrFail($idEvento);
        $this->exigirProgramacao();
        $dados = $request->validate(['status_programacao' => ['required', Rule::in(['ATIVO', 'INATIVO'])]]);
        $alterados = DB::table('tbl_programacao_evento')
            ->where('id_evento', $idEvento)
            ->where('id_programacao', $idProgramacao)
            ->update(['status_programacao' => $dados['status_programacao'], 'updated_at' => now()]);
        abort_unless($alterados, 404, 'Atividade não encontrada neste evento.');

        return $this->voltarAoEvento($idEvento, 'programacao', 'Status da programação atualizado.');
    }

    private function validarProgramacao(Request $request, Eventos $evento, ?int $idPalestranteAtual = null): array
    {
        $dados = $request->validate([
            'titulo_programacao' => ['required', 'string', 'max:150'],
            'descricao_programacao' => ['nullable', 'string', 'max:3000'],
            'inicio_programacao' => ['required', 'date'],
            'fim_programacao' => ['nullable', 'date', 'after_or_equal:inicio_programacao'],
            'local_programacao' => ['nullable', 'string', 'max:150'],
            'palestrante_programacao' => ['nullable', 'string', 'max:150'],
            'id_palestrante' => [
                'nullable', 'integer',
                Rule::exists('tbl_usuarios', 'id_usuario')->where(function ($query) use ($idPalestranteAtual) {
                    $query->where('perfil_usuario', 'palestrante')
                        ->where(function ($subquery) use ($idPalestranteAtual) {
                            $subquery->where('status_usuario', 'ATIVO');
                            if ($idPalestranteAtual !== null) {
                                $subquery->orWhere('id_usuario', $idPalestranteAtual);
                            }
                        });
                }),
            ],
        ], [
            'fim_programacao.after_or_equal' => 'O término deve ser posterior ou igual ao início.',
        ]);

        // Mantém o nome como histórico legível, mas registra também o ID para
        // preservar a associação real com o cadastro de palestrantes.
        if (!empty($dados['id_palestrante'])) {
            abort_unless(Schema::hasColumn('tbl_programacao_evento', 'id_palestrante'), 503,
                'Execute a migration de vínculo de palestrantes antes de selecioná-los.');
            $palestrante = DB::table('tbl_usuarios')
                ->where('id_usuario', $dados['id_palestrante'])
                ->where('perfil_usuario', 'palestrante')
                ->firstOrFail();
            $dados['palestrante_programacao'] = $palestrante->nome_usuario;
        }

        // Mantém o cadastro de responsáveis externos funcionando enquanto a
        // migration adicional ainda não tiver sido executada.
        if (!Schema::hasColumn('tbl_programacao_evento', 'id_palestrante')) {
            unset($dados['id_palestrante']);
        } else {
            $dados['id_palestrante'] = $dados['id_palestrante'] ?? null;
        }

        // Uma programação de uma edição não pode ter horário fora dos dias do próprio evento.
        $inicio = Carbon::parse($dados['inicio_programacao'])->toDateString();
        $fim = isset($dados['fim_programacao'])
            ? Carbon::parse($dados['fim_programacao'])->toDateString()
            : $inicio;
        $primeiroDia = Carbon::parse($evento->data_inicial_evento)->toDateString();
        $ultimoDia = Carbon::parse($evento->data_termino_evento)->toDateString();

        if ($inicio < $primeiroDia || $fim > $ultimoDia) {
            throw ValidationException::withMessages([
                'inicio_programacao' => 'Informe uma data dentro do período do evento ('
                    . Carbon::parse($primeiroDia)->format('d/m/Y') . ' a '
                    . Carbon::parse($ultimoDia)->format('d/m/Y') . ').',
            ]);
        }

        return $dados;
    }

    private function voltarAoEvento(int $idEvento, string $secao, string $mensagem): RedirectResponse
    {
        return redirect()->to(route('admin.eventos.conteudo', ['idEvento' => $idEvento]) . '#' . $secao)
            ->with('success', $mensagem);
    }

    private function exigirVideos(): void
    {
        abort_unless(
            Schema::hasTable('tbl_conteudos') && Schema::hasColumn('tbl_conteudos', 'id_evento'),
            503, 'A tabela de vídeos ainda não está disponível.'
        );
    }

    private function exigirEnquetesVinculadas(): void
    {
        abort_unless(
            Schema::hasTable('tbl_enquetes') && Schema::hasColumn('tbl_enquetes', 'id_evento'),
            503, 'Execute a migration de vínculo das enquetes antes de cadastrar.'
        );
    }

    private function exigirProgramacao(): void
    {
        abort_unless(Schema::hasTable('tbl_programacao_evento'), 503,
            'Execute a migration da programação antes de cadastrar.');
    }

    private function exigirTabelasGaleria(): void
    {
        abort_unless(
            Schema::hasTable('tbl_albuns_evento') && Schema::hasTable('tbl_fotos_evento'),
            503,
            'As tabelas da Galeria ainda não foram criadas neste ambiente.'
        );
    }
}
