<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depoimentos; 
use App\Models\Eventos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DepoimentosController extends Controller
{
    public function indexPalestrante()
    {
      
        return view('palestrante.depoimentos.depoimentos');
    }

        public function indexAdmin()
    {   
        $depoimentos = Depoimentos::with(['usuario','evento'])->get();
        
       // dd($depoimentos->all());
       
        return view('admin.depoimentos.depoimentos', compact('depoimentos'));
    }

    public function createDepoimento(Request $request)
    {
        $request->validate([
            'descricao_depoimento' => 'required|string|max:3000',
        ]);

        $evento = Eventos::where('status_evento', 'ATIVO')->first();

        if (!$evento) {
            return back()->with('error', 'Nenhum evento ativo encontrado.');
        }

        Depoimentos::create([
            'id_usuario'           => Auth::guard('admin')->id(),
            'id_evento'            => $evento->id_evento,
            'descricao_depoimento' => $request->descricao_depoimento,
            'status_depoimento'    => 'PENDENTE',
        ]);

        return redirect()
            ->route('admin.palestrante.depoimento.index')
            ->with('success', 'Depoimento enviado para aprovação.');
    }
}