<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dra;

class DraController extends Controller
{
    //
    public function createDra(Request $request)
    {
        $request->validate([
        'foto_dra'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'titulo_dra' => 'required|string|max:255',
        'sub_titulo_dra' => 'required|string|max:255',
        'descricao_dra'=> 'required|string',
        'status_dra' => 'required|in:ATIVO,INATIVO',
        ]);

        $imagem = $request->file('foto_dra');
        $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
        $imagem->move(public_path('conexao360/img/dra/'), $nomeImagem);
        $caminhoBanner = 'dra/' . $nomeImagem;

        Dra::create([
            'foto_dra' => $caminhoBanner,
            'titulo_dra' => $request->titulo_dra,
            'sub_titulo_dra'  => $request->sub_titulo_dra,
            'descricao_dra'  => $request->descricao_dra,
            'status_dra'  => $request->status_dra,

        ]);

        return redirect()
        ->route('admin.modificar.site')
        ->with('success', 'Informações da Dra criadas com sucesso!');

    }

    public function updateDra(Request $request , $id)
    {

        $request->validate([
        'foto_dra'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'titulo_dra' => 'required|string|max:255',
        'sub_titulo_dra' => 'required|string|max:255',
        'descricao_dra'=> 'required|string',
        'status_dra' => 'required|in:ATIVO,INATIVO',
        ]);

        $dra = Dra::findOrFail($id);

        $caminhoBanner = $dra->foto_dra;

        if ($request->hasFile('foto_dra')) {
             $imagem = $request->file('foto_dra');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/dra/'), $nomeImagem);
            $caminhoBanner = 'dra/' . $nomeImagem;
        }

        $dra->update([
            'foto_dra' => $caminhoBanner,
            'titulo_dra' => $request->titulo_dra,
            'sub_titulo_dra'  => $request->sub_titulo_dra,
            'descricao_dra'  => $request->descricao_dra,
            'status_dra'  => $request->status_dra,
        ]);

        return redirect()
        ->route('admin.modificar.site')
        ->with('success', 'Dados Dra editado com sucesso!');

    }
}
