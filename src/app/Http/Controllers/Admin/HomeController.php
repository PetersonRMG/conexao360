<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // IMPORTANTE: Importe a classe base Controller
use Illuminate\Http\Request;
use App\Models\HeroSection;

class HomeController extends Controller
{
    // Método para exibir a página principal
    public function index()
    {
        $hero = HeroSection::first();
        return view('site.home.home', compact('hero'));
    }

    // Método para atualizar informações da Home
    public function update(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            // adicione outras validações conforme necessário
        ]);

        $hero = HeroSection::first() ?? new HeroSection();
        
        // Lógica de upload de imagem (similar ao seu DashController)
        if ($request->hasFile('foto_banner')) {
            $imagem = $request->file('foto_banner');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('conexao360/img/hero/'), $nomeImagem);
            $hero->foto_banner = '/hero/' . $nomeImagem;
        }

        $hero->fill($request->only(['titulo', 'subtitulo', 'tagline']));
        $hero->save();

        return redirect()->back()->with('success', 'Alterações salvas com sucesso!');
    }
}