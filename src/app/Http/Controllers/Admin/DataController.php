<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\DraSimone;
use App\Models\Tema;
use Illuminate\Support\Facades\Storage;

class DashController extends Controller
{
    // Exibe a página do Dashboard com todos os dados
    public function index()
    {
        $data = [
            'hero'   => HeroSection::first(),
            'dra'    => DraSimone::first(),
            'temas'  => Tema::all(),
        ];
        return view('admin.dash.content', $data);
    }

    // Atualiza o Banner (Hero)
    public function updateHero(Request $request)
    {
        $hero = HeroSection::first() ?? new HeroSection();
        
        $request->validate([
            'titulo' => 'required|string',
            'foto_fundo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto_fundo')) {
            if ($hero->foto_fundo) Storage::disk('public')->delete($hero->foto_fundo);
            $hero->foto_fundo = $request->file('foto_fundo')->store('banners', 'public');
        }

        $hero->titulo = $request->titulo;
        $hero->subtitulo = $request->subtitulo;
        $hero->save();

        return redirect()->back()->with('success', 'Banner principal atualizado!');
    }
}