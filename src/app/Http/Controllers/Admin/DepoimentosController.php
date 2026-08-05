<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depoimentos; 
use App\Models\Eventos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use ResourceBundle;

class DepoimentosController extends Controller
{
    public function indexPalestrante()
    {

       $idUsuario = Auth::guard('admin')->id();

        $query = Depoimentos::with(['usuario','evento'])
        ->where ('id_usuario', $idUsuario);

        $depoimentos = (clone $query)->get();

        $depoimentosPend = (clone $query)
        ->where('status_depoimento', 'PENDENTE')
        ->get();
        $depoimentosAceitos = (clone $query)
        ->where('status_depoimento', 'ATIVO')
        ->get();
        $depoimentosRegei = (clone $query)
        ->where('status_depoimento', 'RECUSADO')
        ->get();

       
        return view('palestrante.depoimentos.depoimentos', compact('depoimentos', 'depoimentosPend','depoimentosRegei','depoimentosAceitos'));

        
    }

        public function indexAdmin()
    {   
        $depoimentos = Depoimentos::with(['usuario','evento'])
        
        ->get();

        $depoimentosPend = Depoimentos::with(['usuario','evento'])
         ->where('status_depoimento', 'PENDENTE')
         ->get();

        $depoimentosAceitos = Depoimentos::with(['usuario','evento'])
         ->where('status_depoimento', 'ATIVO')
         ->get();

        $depoimentosRegei = Depoimentos::with(['usuario','evento'])
         ->where('status_depoimento', 'RECUSADO')
         ->get();
        
       // dd($depoimentos->all());
       
        return view('admin.depoimentos.depoimentos', compact('depoimentos', 'depoimentosPend','depoimentosRegei','depoimentosAceitos'));
    }

    public function DepoAceitar($id)
    {   
        $depoimentos = Depoimentos::findOrFail($id);

        $depoimentos->update([
            'status_depoimento' => 'ATIVO'
        ]);
        
       // dd($depoimentos->all());
       
        return redirect() 
        ->route('admin.depoimentos.index');
    }

        public function DepoRecusar( $id)
    {   
        $depoimentos = Depoimentos::findOrFail($id);

        $depoimentos->update([
            'status_depoimento' => 'RECUSADO'
        ]);
        
       // dd($depoimentos->all());
       
        return redirect() 
        ->route('admin.depoimentos.index');
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