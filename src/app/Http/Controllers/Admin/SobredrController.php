<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dra;

class SobreDraController extends Controller
{
    public function update(Request $request)
    {
        $dra = Dra::first() ?? new Dra();

        if ($request->hasFile('foto_dra')) {
            $imagem = $request->file('foto_dra');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/dra/'), $nomeImagem);
            $dra->foto_dra = 'dra/' . $nomeImagem;
        }

        $dra->nome_dra  = $request->nome_dra;
        $dra->cargo_dra = $request->cargo_dra;
        $dra->texto_dra = $request->texto_dra;
        $dra->status_dra = 'ATIVO'; 
        $dra->save();

        return redirect()->route('admin.dash')->with('success', 'Dados da Dra. Simone atualizados com sucesso!');
    }
}