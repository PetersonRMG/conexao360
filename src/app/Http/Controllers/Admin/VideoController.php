<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    //
    public function createVideo(Request $request)
    {
        $request->validate([
            'titulo_video'            => 'required|string|max:255',
            'subtitulo_video'         => 'required|string',
            'legenda_video'            => 'required|string|max:255',
            'breve_descricao_video'   => 'required|string|max:255',
            'status_video'            => 'required|in:ATIVO,INATIVO',
            'url_video'               => 'nullable|file|mimes:mp4,webm,mov|max:51200', 
            'capa_video'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $caminhoVideo = null;
        $caminhoCapa = null;

        // Upload do vídeo
        if ($request->hasFile('url_video')) {

            $video = $request->file('url_video');

            $nomeVideo = time() . '.' . $video->getClientOriginalExtension();

            $video->move(
                public_path('conexao360/img/video/'),
                $nomeVideo
            );

            $caminhoVideo = 'video/' . $nomeVideo;
        }

        // Upload da capa
        if ($request->hasFile('capa_video')) {

            $capa = $request->file('capa_video');

            $nomeCapa = time() . '.' . $capa->getClientOriginalExtension();

            $capa->move(
                public_path('conexao360/img/video/'),
                $nomeCapa
            );
            $caminhoCapa = 'video/' . $nomeCapa;
        }

        Video::create([
            'titulo_video'            => $request->titulo_video,
            'subtitulo_video'         => $request->subtitulo_video,
            'legenda_video'            =>  $request->legenda_video,
            'breve_descricao_video'   => $request->breve_descricao_video,
            'status_video'            => $request->status_video,
            'url_video'               => $caminhoVideo,
            'capa_video'              => $caminhoCapa,
        ]);


        return redirect()
        ->route('admin.dash')
        ->with('success', 'Video criado com sucesso!');
    }
    public function updateVideo(Request $request, $id)
    {
            $request->validate([
            'titulo_video'            => 'required|string|max:255',
            'subtitulo_video'         => 'required|string',
            'legenda_video'            => 'required|string|max:255',
            'breve_descricao_video'   => 'required|string|max:255',
            'status_video'            => 'required|in:ATIVO,INATIVO',
            'url_video'               => 'nullable|file|mimes:mp4,webm,mov|max:51200', 
            'capa_video'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $videos = Video::findOrFail($id);

        $caminhoVideo = null;
        $caminhoCapa = null;

        // Upload do vídeo
        if ($request->hasFile('url_video')) {

            $video = $request->file('url_video');

            $nomeVideo = time() . '.' . $video->getClientOriginalExtension();

            $video->move(
                public_path('conexao360/img/video/'),
                $nomeVideo
            );

            $caminhoVideo = 'video/' . $nomeVideo;
        }

        // Upload da capa
        if ($request->hasFile('capa_video')) {

            $capa = $request->file('capa_video');

            $nomeCapa = time() . '.' . $capa->getClientOriginalExtension();

            $capa->move(
                public_path('conexao360/img/video/'),
                $nomeCapa
            );
            $caminhoCapa = 'video/' . $nomeCapa;
        }

        $videos->update([
            'titulo_video'            => $request->titulo_video,
            'subtitulo_video'         => $request->subtitulo_video,
            'legenda_video'            =>  $request->legenda_video,
            'breve_descricao_video'   => $request->breve_descricao_video,
            'status_video'            => $request->status_video,
            'url_video'             => $caminhoVideo ?? $videos->url_video,
            'capa_video'            => $caminhoCapa ?? $videos->capa_video,
        ]);


        return redirect()
        ->route('admin.dash')
        ->with('success', 'Video editado com sucesso!');
    }
}
