<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use App\Models\HeroSection; // Importando o novo Model da Sessão Principal
use App\Models\Eventos;
use Illuminate\Support\Str;

class DashController extends Controller
{
  
    public function index()
    {
        $evento = Eventos::where('status_evento', 'ATIVO')
        ->get();

        $temas = Temas::orderBy('status_tema')
        ->inRandomOrder()        
        ->get();

        $dra = Dra::where('status_dra', 'ATIVO')               
        ->get();

        $video = Video::where('status_video', 'ATIVO')               
        ->get();

            //dd( $dra);
        return view('admin/dash/dashboard',compact('temas', 'dra', 'video','evento'));
       
    }

    public function create(Request $request)
    {
        $request->validate([
            'titulo_tema'       => 'required|string|max:100',
            'subtitulo_tema'       => 'required|string|max:200',
            'breve_descricao_tema' => 'required|string',
            'foto_tema'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_tema'    => 'required|in:ATIVO,INATIVO',
            
        ]);

        $fotoTema = $request->file('foto_tema');
   
        $nomeFoto = time() . '.' . $fotoTema->getClientOriginalExtension();
        $fotoTema->move(public_path('conexao360/img/tema'), $nomeFoto);
        $caminhoFoto = 'tema/' . $nomeFoto;


        Temas::create([
            'titulo_tema'      => $request->titulo_tema,          
            'subtitulo_tema'      => $request->subtitulo_tema,
            'breve_descricao_tema' => $request->breve_descricao_tema,
            'foto_tema'      => $caminhoFoto,
            'status_tema'    => $request->status_tema,

        ]);

        return redirect()
        ->route('admin.dash')
        ->with('success', 'Tema criado com sucesso!');

    }

    public function update(Request $request, $id)
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


    public function updateVideo(Request $request, $id)
    {
        $request->validate([
            'titulo_video'            => 'required|string|max:100',
            'subtitulo_video'         => 'required|string|max:200',
            'legenda_video'           => 'required|string|max:100',
            'breve_descricao_video'   => 'required|string',
            'capa_video'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'url_video'               => 'nullable|file|mimes:mp4,avi,mov,webm|max:102400',
            'status_video'            => 'required|in:ATIVO,INATIVO',
        ]);

        $item = Video::findOrFail($id);

        // Mantém os arquivos atuais
        $caminhoCapa = $item->capa_video;
        $caminhoVideo = $item->url_video;

        // Upload da capa
        if ($request->hasFile('capa_video')) {

            $imagem = $request->file('capa_video');

            $nomeImagem = time() . '_capa.' . $imagem->getClientOriginalExtension();

            $imagem->move(
                public_path('conexao360/img/video/'),
                $nomeImagem
            );

            $caminhoCapa = 'video/' . $nomeImagem;
        }

        // Upload do vídeo
        if ($request->hasFile('url_video')) {

            $video = $request->file('url_video');

            $nomeVideo = time() . '_video.' . $video->getClientOriginalExtension();

            $video->move(
                public_path('conexao360/img/video/'),
                $nomeVideo
            );

            $caminhoVideo = 'videos/' . $nomeVideo;
        }

        $item->update([
            'titulo_video'           => $request->titulo_video,
            'subtitulo_video'        => $request->subtitulo_video,
            'legenda_video'          => $request->legenda_video,
            'breve_descricao_video'  => $request->breve_descricao_video,
            'capa_video'             => $caminhoCapa,
            'url_video'              => $caminhoVideo,
            'status_video'           => $request->status_video,
        ]);

        return redirect()
            ->route('admin.dash')
            ->with('success', 'Vídeo editado com sucesso!');
    }

    
}

