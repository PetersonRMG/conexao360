<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Publicacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModeracaoController extends Controller
{
    public function index()
    {
        $relacionamentos = [
            'publicacao' => fn ($query) => $query
                ->withCount('denuncias')
                ->with(['usuario', 'evento']),
            'denunciante',
            'moderador',
        ];

        $denunciasPendentes = Denuncia::with($relacionamentos)
            ->where('status_denuncia', 'PENDENTE')
            ->orderByDesc('criado_em_denuncia')
            ->get();

        $denunciasAnalisadas = Denuncia::with($relacionamentos)
            ->where('status_denuncia', 'ANALISADA')
            ->orderByDesc('analisado_em_denuncia')
            ->get();

        return view('admin.moderacao.index', compact(
            'denunciasPendentes',
            'denunciasAnalisadas'
        ));
    }

    public function analisar(Request $request, $id)
    {
        $dados = $request->validate([
            'decisao_denuncia' => ['required', 'in:MANTER,OCULTAR'],
            'observacao_moderador' => ['nullable', 'string', 'max:2000'],
        ]);

        $moderador = Auth::guard('admin')->user();

        $resultado = DB::transaction(function () use ($id, $dados, $moderador) {
            $registro = Denuncia::findOrFail($id);

            // Mesma ordem de bloqueio utilizada pelo endpoint da API:
            // primeiro publicação, depois denúncia.
            $publicacao = Publicacao::whereKey($registro->id_publicacao)
                ->lockForUpdate()
                ->firstOrFail();

            $denuncia = Denuncia::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($denuncia->status_denuncia !== 'PENDENTE') {
                return 'ja_analisada';
            }

            // A decisão administrativa controla o status do post.
            // "MANTER" deve restaurar ATIVO, já que a denúncia ocultou o post.
            $publicacao->update([
                'status_publicacao' => $dados['decisao_denuncia'] === 'MANTER'
                    ? 'ATIVO'
                    : 'OCULTO',
            ]);

            $denuncia->update([
                'id_usuario_moderador' => $moderador->id_usuario,
                'status_denuncia' => 'ANALISADA',
                'decisao_denuncia' => $dados['decisao_denuncia'],
                'observacao_moderador' => $dados['observacao_moderador'] ?? null,
                'analisado_em_denuncia' => now(),
            ]);

            return 'ok';
        }, 3);

        if ($resultado === 'ja_analisada') {
            return redirect()
                ->route('admin.moderacao.index')
                ->with('error', 'Esta denúncia já foi analisada.');
        }

        $mensagem = $dados['decisao_denuncia'] === 'OCULTAR'
            ? 'Denúncia analisada. A publicação permanece oculta.'
            : 'Denúncia analisada. A publicação voltou ao feed.';

        return redirect()
            ->route('admin.moderacao.index')
            ->with('success', $mensagem);
    }
}
