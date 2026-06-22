<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use App\Models\Feed;
use App\Models\User;
use App\Models\Video;

class NetworkController extends Controller
{
    public function index()
    {
        $usuario = User::find(1);

        $feeds = Feed::with([
            'usuario',
            'comentarios.usuario'
        ])
        ->orderByDesc('id_feeds')
        ->get();

        $videos = Video::where(
            'status_video',
            'ATIVO'
        )->get();

        $eventos = Eventos::where(
            'status_evento',
            'ATIVO'
        )->get();

        return view(
            'site.network.network',
            compact(
                'usuario',
                'feeds',
                'videos',
                'eventos'
            )
        );
    }
}