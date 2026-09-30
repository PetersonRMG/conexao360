<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquete;
use Illuminate\Http\Request;

class EnquetesController extends Controller
{
    public function index()
    {
        $enquetes = Enquete::query()
            ->withCount([
                'respostas as votos_sim' => fn ($query) => $query->where('resposta_resposta', 1),
                'respostas as votos_nao' => fn ($query) => $query->where('resposta_resposta', 2),
                'respostas as votos_outro' => fn ($query) => $query->where('resposta_resposta', 3),
                'respostas as total_votos',
            ])
            ->orderByDesc('id_enquete')
            ->get();

        return view('admin.enquetes.index', compact('enquetes'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'pergunta_enquete' => 'required|string|max:80',
        ], [
            'pergunta_enquete.required' => 'Informe a pergunta da enquete.',
            'pergunta_enquete.max' => 'A pergunta deve ter no máximo 80 caracteres.',
        ]);

        Enquete::create([
            'pergunta_enquete' => $dados['pergunta_enquete'],
        ]);

        return redirect()
            ->route('admin.enquetes.index')
            ->with('success', 'Enquete criada com sucesso.');
    }
}
