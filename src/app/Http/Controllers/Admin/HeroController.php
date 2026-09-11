<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    /**
     * Quantidade máxima de banners ativos no carrossel.
     */
    private const MAX_HERO_ATIVOS = 3;


    /**
     * Criar Hero
     */
    public function createHero(Request $request)
    {
        $request->validate([
            'titulo_hero'      => 'required|string|max:255',
            'tagline_hero'     => 'nullable|string|max:255',
            'subtitulo_hero'   => 'nullable|string',
            'texto_botao_hero' => 'nullable|string|max:100',
            'link_botao_hero'  => 'nullable|string',
            'foto_banner'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_hero'      => 'required|in:ATIVO,INATIVO',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Limite de banners ativos
        |--------------------------------------------------------------------------
        */
        if ($request->status_hero === 'ATIVO') {

            $totalAtivos = HeroSection::where('status_hero', 'ATIVO')->count();

            if ($totalAtivos >= self::MAX_HERO_ATIVOS) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'status_hero' =>
                            'Já existem 3 banners ativos. Desative um deles antes de ativar outro.'
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Upload da imagem
        |--------------------------------------------------------------------------
        */
        $caminhoBanner = null;

        if ($request->hasFile('foto_banner')) {

            $imagem = $request->file('foto_banner');

            $nomeImagem =
                time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();

            $imagem->move(
                public_path('conexao360/img/hero/'),
                $nomeImagem
            );

            $caminhoBanner = 'hero/' . $nomeImagem;
        }


        /*
        |--------------------------------------------------------------------------
        | Cadastro
        |--------------------------------------------------------------------------
        */
        HeroSection::create([
            'titulo_hero'      => $request->titulo_hero,
            'tagline_hero'     => $request->tagline_hero,
            'subtitulo_hero'   => $request->subtitulo_hero,
            'texto_botao_hero' => $request->texto_botao_hero,
            'link_botao_hero'  => $request->link_botao_hero,
            'foto_banner'      => $caminhoBanner,
            'status_hero'      => $request->status_hero,
        ]);


        return redirect()
            ->route('admin.modificar.site')
            ->with('success', 'Banner criado com sucesso!');
    }


    /**
     * Atualizar Hero
     */
    public function updateHero(Request $request, $id)
    {
        $request->validate([
            'titulo_hero'      => 'required|string|max:255',
            'tagline_hero'     => 'nullable|string|max:255',
            'subtitulo_hero'   => 'nullable|string',
            'texto_botao_hero' => 'nullable|string|max:100',
            'link_botao_hero'  => 'nullable|string',
            'foto_banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_hero'      => 'required|in:ATIVO,INATIVO',
        ]);


        $hero = HeroSection::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Limite de 3 ativos
        |--------------------------------------------------------------------------
        |
        | Ignoramos o próprio Hero na contagem.
        |
        */
        if ($request->status_hero === 'ATIVO') {

            $totalAtivos = HeroSection::where('status_hero', 'ATIVO')
                ->where('id_hero_section', '!=', $hero->id_hero_section)
                ->count();


            if ($totalAtivos >= self::MAX_HERO_ATIVOS) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'status_hero' =>
                            'Já existem 3 banners ativos. Desative um deles antes de ativar este banner.'
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Mantém imagem atual
        |--------------------------------------------------------------------------
        */
        $caminhoBanner = $hero->foto_banner;


        /*
        |--------------------------------------------------------------------------
        | Nova imagem
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('foto_banner')) {

            $imagem = $request->file('foto_banner');

            $nomeImagem =
                time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();

            $imagem->move(
                public_path('conexao360/img/hero/'),
                $nomeImagem
            );

            $caminhoBanner = 'hero/' . $nomeImagem;
        }


        /*
        |--------------------------------------------------------------------------
        | Atualização
        |--------------------------------------------------------------------------
        */
        $hero->update([
            'titulo_hero'      => $request->titulo_hero,
            'tagline_hero'     => $request->tagline_hero,
            'subtitulo_hero'   => $request->subtitulo_hero,
            'texto_botao_hero' => $request->texto_botao_hero,
            'link_botao_hero'  => $request->link_botao_hero,
            'foto_banner'      => $caminhoBanner,
            'status_hero'      => $request->status_hero,
        ]);


        return redirect()
            ->route('admin.modificar.site')
            ->with(
                'success',
                'Banner atualizado com sucesso!'
            );
    }
}