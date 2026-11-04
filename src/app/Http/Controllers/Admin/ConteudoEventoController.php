<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
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

        return view('admin.eventos.index', compact(
            'evento', 'galeriaDisponivel', 'albuns', 'totalFotos',
            'videosDisponiveis', 'videos', 'enquetesVinculadas', 'enquetes'
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

    private function exigirTabelasGaleria(): void
    {
        abort_unless(
            Schema::hasTable('tbl_albuns_evento') && Schema::hasTable('tbl_fotos_evento'),
            503,
            'As tabelas da Galeria ainda não foram criadas neste ambiente.'
        );
    }
}
