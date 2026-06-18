<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroController extends Controller
{


    public function createHero(Request $request){
         $request->validate([
            'titulo_hero'       => 'required|string|max:255',
            'tagline_hero'      => 'nullable|string|max:255',
            'subtitulo_hero'    => 'nullable|string',
            'texto_botao_hero'  => 'nullable|string|max:100',
            'link_botao_hero'   => 'nullable|string',
            'foto_banner'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_hero'       => 'required|in:ATIVO,INATIVO'
        ]);


            $imagem = $request->file('foto_banner');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/hero/'), $nomeImagem);
            $caminhoBanner = 'hero/' . $nomeImagem;

        HeroSection::create([
            'titulo_hero'      => $request->titulo_hero,          
            'tagline_hero'      => $request->tagline_hero,
            'subtitulo_hero' => $request->subtitulo_hero,
            'texto_botao_hero'      => $request->texto_botao_hero,
            'link_botao_hero'    => $request->link_botao_hero,
            'foto_banner'       =>  $caminhoBanner,
            'status_hero'       =>  $request->status_hero,
        ]);

        return redirect()
        ->route('admin.modificar.site')
        ->with('success', 'Banner criado com sucesso!');


    }


    public function updateHero(Request $request, $id )
    {      

        $request->validate([
            'titulo_hero'       => 'required|string|max:255',
            'tagline_hero'      => 'nullable|string|max:255',
            'subtitulo_hero'    => 'nullable|string',
            'texto_botao_hero'  => 'nullable|string|max:100',
            'link_botao_hero'   => 'nullable|string',
            'foto_banner'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_hero'       => 'required|in:ATIVO,INATIVO'
        ]);

        // FORÇA pegar o primeiro registro do banco. Se não existir nenhum, cria um novo!
        $hero = HeroSection::findOrFail($id);
        

        $caminhoBanner = $hero->foto_banner;

        if ($request->hasFile('foto_banner')) {
            $imagem = $request->file('foto_banner');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/hero/'), $nomeImagem);
            $caminhoBanner = 'hero/' . $nomeImagem;
        }

        $hero->fill($request->only(['tagline', 'titulo', 'subtitulo', 'texto_botao', 'link_botao', 'status']));
        $hero->foto_banner = $caminhoBanner;
        $hero->save();


        
        $hero->update([
            'titulo_hero'      => $request->titulo_hero,          
            'tagline_hero'      => $request->tagline_hero,
            'subtitulo_hero' => $request->subtitulo_hero,
            'texto_botao_hero'      => $request->texto_botao_hero,
            'link_botao_hero'    => $request->link_botao_hero,
            'foto_banner'       =>  $caminhoBanner,
            'status_hero'       =>  $request->status_hero,
        ]);

 
        return redirect()->route('admin.modificar.site')->with('success', 'Sessão Principal salva com sucesso no banco!');
    }
}