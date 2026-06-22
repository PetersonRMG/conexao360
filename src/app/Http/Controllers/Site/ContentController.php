<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    /**
     * Lista os conteúdos e vídeos para a área administrativa da rede.
     */
    public function index()
    {
        // Busca vídeos ativos para a secção de media
        $videos = DB::table('tbl_videos')
            ->where('status_video', 'ATIVO')
            ->orderBy('criado_em_video', 'DESC')
            ->get();

        // Busca palestras disponíveis
        $palestras = DB::table('tbl_palestras')
            ->where('status_palestra', 'ATIVA')
            ->orderBy('data_palestra', 'ASC')
            ->get();

        return view('site.content', compact('videos', 'palestras'));
    }
}