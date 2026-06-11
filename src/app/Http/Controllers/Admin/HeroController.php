<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;

class HeroController extends Controller
{
    public function update(Request $request)
    {
        $hero = HeroSection::first();

        $dados = [
            'tagline_hero'     => $request->tagline_hero,
            'titulo_hero'      => $request->titulo_hero,
            'subtitulo_hero'   => $request->subtitulo_hero,
            'texto_botao_hero' => $request->texto_botao_hero,
            'link_botao_hero'  => $request->link_botao_hero,
        ];

        if ($request->hasFile('foto_banner')) {

            $arquivo = $request->file('foto_banner');

            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();

            $arquivo->move(
                public_path('conexao360/img'),
                $nomeArquivo
            );

            $dados['foto_banner'] = $nomeArquivo;
        }

        $hero->update($dados);

        return redirect()
            ->back()
            ->with('success', 'Banner atualizado com sucesso!');
    }
}