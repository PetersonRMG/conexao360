<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModeracaoController extends Controller
{
    public function index()
    {
        $relacionamentos = [
            'publicacao.usuario',
            'publicacao.evento',
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
            'decisao_denuncia' => 'required|in:MANTER,OCULTAR',
            'observacao_moderador' => 'nullable|string|max:2000',
        ]);

        $moderador = Auth::guard('admin')->user();

        $resultado = DB::transaction(function () use ($id, $dados, $moderador) {
            $denuncia = Denuncia::with('publicacao')
                ->lockForUpdate()
                ->findOrFail($id);

            if ($denuncia->status_denuncia !== 'PENDENTE') {
                return 'ja_analisada';
            }

            if ($dados['decisao_denuncia'] === 'OCULTAR') {
                $denuncia->publicacao->update([
                    'status_publicacao' => 'OCULTO',
                ]);
            }

            $denuncia->update([
                'id_usuario_moderador' => $moderador->id_usuario,
                'status_denuncia' => 'ANALISADA',
                'decisao_denuncia' => $dados['decisao_denuncia'],
                'observacao_moderador' => $dados['observacao_moderador'] ?? null,
                'analisado_em_denuncia' => now(),
            ]);

            return 'ok';
        });

        if ($resultado === 'ja_analisada') {
            return redirect()
                ->route('admin.moderacao.index')
                ->with('error', 'Esta denúncia já foi analisada.');
        }

        $mensagem = $dados['decisao_denuncia'] === 'OCULTAR'
            ? 'Denúncia analisada e publicação ocultada com sucesso.'
            : 'Denúncia analisada. A publicação foi mantida.';

        return redirect()
            ->route('admin.moderacao.index')
            ->with('success', $mensagem);
    }
}
