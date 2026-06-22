<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnqueteController extends Controller
{
    /**
     * Exibe a página de enquetes com a enquete mais recente.
     */
    public function enquete()
    {
        // 1. Buscamos apenas a enquete mais recente que esteja ativa
        $enquete = DB::table('tbl_enquetes')
            ->where('status_enquete', 'ATIVA')
            ->orderBy('criado_em_enquete', 'DESC')
            ->first(); // Usamos first() para pegar apenas um objeto, não uma coleção

        // 2. Se houver uma enquete, buscamos as opções associadas a ela
        if ($enquete) {
            $enquete->opcoes = DB::table('tbl_opcoes_enquete')
                ->where('id_enquete', $enquete->id_enquete)
                ->get();
            
            // Calculamos o total de votos para o componente exibir as barras de progresso
            $enquete->total_votos = $enquete->opcoes->sum('votos');
        }

        return view('site.enquete.enquete', compact('enquete'));
    }
}