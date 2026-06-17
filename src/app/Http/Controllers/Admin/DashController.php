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

        $video = Video::orderBy('status_video')               
        ->get();

        $hero = HeroSection::orderBy('status_hero')
        ->get();    

        //dd( $dra);
        return view('admin/dash/dashboard',compact('temas', 'dra', 'video','evento', 'hero'));
       
    }


    /**
     * Atualiza os dados da Sessão Principal (Hero Section)
     */



    
}

