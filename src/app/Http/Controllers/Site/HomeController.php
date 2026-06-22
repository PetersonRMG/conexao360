<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use App\Models\Eventos;

class HomeController extends Controller
{
    public function index()
    {
        $evento = Eventos::orderBy(
            'id_evento'
        )->get();

        $temas = Temas::with(
            'eventos'
        )
        ->where(
            'status_tema',
            'ATIVO'
        )
        ->inRandomOrder()
        ->get();

        $dra = Dra::with(
            'eventos'
        )
        ->where(
            'status_dra',
            'ATIVO'
        )
        ->get();

        $video = Video::where(
            'status_video',
            'ATIVO'
        )->get();

        return view(
            'site.home.home',
            compact(
                'temas',
                'dra',
                'video',
                'evento'
            )
        );
    }
}