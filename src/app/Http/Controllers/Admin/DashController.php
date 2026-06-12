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
        $evento = Eventos::orderBy('status_evento')
        ->get();

        $temas = Temas::orderBy('status_tema')
        ->inRandomOrder()        
        ->get();

        $dra = Dra::orderBy('status_dra')               
        ->get();

        $video = Video::where('status_video', 'ATIVO')               
        ->get();

        $hero = HeroSection::orderBy('status_hero')
        ->get();    

            //dd( $dra);
        return view('admin/dash/dashboard',compact('temas', 'dra', 'video','evento', 'hero'));
       
    }





    /**
     * Atualiza os dados da Sessão Principal (Hero Section)
     */



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

