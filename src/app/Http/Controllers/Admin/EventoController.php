<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eventos; 

class EventoController extends Controller
{
    public function createEvento(Request $request)
    {
        $request->validate([
            'banner_evento'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'titulo_evento'         => 'required|string|max:255',
            'edicao_evento'         => 'required|string|max:100',
            'descricao_evento'      => 'required|string',
            'data_inicial_evento'   => 'required|date',
            'hora_inicial_evento'   => 'required',
            'endereco_evento'       => 'required|string|max:255',
            'url_evento'            => 'nullable|url|max:255',
            'status_evento'         => 'required|in:ATIVO,INATIVO',
            'data_termino_evento'   => 'required|date|after_or_equal:data_inicial_evento',
            'hora_termino_evento'   => 'required',
        ]);

        $imagem = $request->file('banner_evento');
        $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
        $imagem->move(public_path('conexao360/img/evento/'), $nomeImagem);
        $caminhoBanner = 'evento/' . $nomeImagem;

        Eventos::create([
            'banner_evento' => $caminhoBanner,
            'titulo_evento' => $request->titulo_evento,
            'edicao_evento'  => $request->edicao_evento,
            'descricao_evento'  => $request->descricao_evento,
            'data_inicial_evento'  => $request->data_inicial_evento,
            'hora_inicial_evento'  => $request->hora_inicial_evento,
            'endereco_evento'  => $request->endereco_evento,
            'url_evento'  => $request->url_evento,
            'status_evento'  => $request->status_evento,
            'data_termino_evento'  => $request->data_termino_evento,
            'hora_termino_evento'  => $request->hora_termino_evento,

        ]);


        return redirect()
        ->route('admin.dash')
        ->with('success', 'Evento criado com sucesso!');
    }

    public function updateEvento(Request $request, $id )
    {      

         $request->validate([
            'banner_evento'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'titulo_evento'         => 'required|string|max:255',
            'edicao_evento'         => 'required|string|max:100',
            'descricao_evento'      => 'required|string',
            'data_inicial_evento'   => 'required|date',
            'hora_inicial_evento'   => 'required',
            'endereco_evento'       => 'required|string|max:255',
            'url_evento'            => 'nullable|url|max:255',
            'status_evento'         => 'required|in:ATIVO,INATIVO',
            'data_termino_evento'   => 'required|date|after_or_equal:data_inicial_evento',
            'hora_termino_evento'   => 'required',
        ]);
        

        $evento = Eventos::findOrFail($id);
        

        $caminhoBanner = $evento->banner_evento;

        if ($request->hasFile('banner_evento')) {
             $imagem = $request->file('banner_evento');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/evento/'), $nomeImagem);
            $caminhoBanner = 'evento/' . $nomeImagem;
        }
        


        
        $evento->update([
            'banner_evento'         => $caminhoBanner,
            'titulo_evento'         => $request->titulo_evento,
            'edicao_evento'         => $request->edicao_evento,
            'descricao_evento'      => $request->descricao_evento,
            'data_inicial_evento'   => $request->data_inicial_evento,
            'hora_inicial_evento'   => $request->hora_inicial_evento,
            'endereco_evento'       => $request->endereco_evento,
            'url_evento'            => $request->url_evento,
            'status_evento'         => $request->status_evento,
            'data_termino_evento'   => $request->data_termino_evento,
            'hora_termino_evento'   => $request->hora_termino_evento,
        ]);

        
        return redirect()->route('admin.dash')->with('success', 'Evento editado com sucesso!');
    } 
}