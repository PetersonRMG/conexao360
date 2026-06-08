<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use Illuminate\Support\Str;

class DashController extends Controller
{
    //
    public function index()
    {
        $temas = Temas::orderBy('status_tema')
        ->inRandomOrder()        
        ->get();

        $dra = Dra::where('status_dra', 'ATIVO')               
        ->get();

        $video = Video::where('status_video', 'ATIVO')               
        ->get();

            //dd( $video);
        return view('admin/dash/dashboard',compact('temas', 'dra', 'video'));
       
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
        //dd($request);
        $request->validate([
            'titulo_tema'       => 'required|string|max:100',
            'subtitulo_tema'       => 'required|string|max:200',
            'breve_descricao_tema' => 'required|string',
            'foto_tema'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_tema'    => 'required|in:ATIVO,INATIVO',
            
        ]);

        $item = Temas::findOrFail($id);

      

        // mantém a foto antiga
        $caminhoFoto = $item->foto_tema;

        // se enviou nova foto
        if ($request->hasFile('foto_tema')) {

            $imagem = $request->file('foto_tema');

            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();

            $imagem->move(
                public_path('conexao360/img/tema/'),
                $nomeImagem
            );

            $caminhoFoto = 'tema/' . $nomeImagem;
        }

        $item->update([
            'titulo_tema'      => $request->titulo_tema,          
            'subtitulo_tema'      => $request->subtitulo_tema,
            'breve_descricao_tema' => $request->breve_descricao_tema,
            'foto_tema'      => $caminhoFoto,
            'status_tema'    => $request->status_tema,

        ]);

        return redirect()       
            ->route('admin.dash')     
            ->with('success', 'Tema Editado com sucesso!');

       
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
