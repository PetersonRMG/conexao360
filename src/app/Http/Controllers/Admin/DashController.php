<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use App\Models\HeroSection; // Importando o novo Model da Sessão Principal
use Illuminate\Support\Str;

class DashController extends Controller
{
    public function index()
    {
        $temas = Temas::orderBy('status_tema')
            ->inRandomOrder()        
            ->first();

        $dra = Dra::where('status_dra', 'ATIVO')            
            ->first();

        $video = Video::where('status_video', 'ATIVO')              
            ->first(); 

        // Busca o primeiro registro da Hero Section. Se não existir, inicia um objeto vazio para não quebrar a view.
        $hero = HeroSection::first() ?? new HeroSection();

        return view('admin/dash/dashboard', compact('temas', 'dra', 'video', 'hero'));
    }



 /**
     * Atualiza os dados da Sessão Principal (Hero Section)
     */
    public function updateHero(Request $request, $id = null)
    {

       

        $request->validate([
            'titulo'       => 'required|string|max:255',
            'tagline'      => 'nullable|string|max:255',
            'subtitulo'    => 'nullable|string',
            'texto_botao'  => 'nullable|string|max:100',
            'link_botao'   => 'nullable|string',
            'foto_banner'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'       => 'required|in:ATIVO,INATIVO'
        ]);

        // FORÇA pegar o primeiro registro do banco. Se não existir nenhum, cria um novo!
        $hero = HeroSection::first();
        if (!$hero) {
            $hero = new HeroSection();
        }

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

        // Retorna explicitamente para a página do painel com a mensagem real do Hero
        return redirect()->route('admin.dash')->with('success', 'Sessão Principal salva com sucesso no banco!');

  


    




    }
}