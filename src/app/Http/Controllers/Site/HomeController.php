<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use App\Models\Eventos;
use App\Models\HeroSection;
use App\Models\Depoimentos;


class HomeController extends Controller 
{
    //
    public function index(){  

        $temas = Temas::where('status_tema', 'ATIVO')        
        ->inRandomOrder()        
        ->get();

        $dra = Dra::where('status_dra', 'ATIVO')                     
        ->get();

        $video = Video::where('status_video','ATIVO')                    
        ->get();

        $hero = HeroSection::where('status_hero', 'ATIVO')
        ->get();

        $evento = Eventos::where('status_evento', 'ATIVO')
        ->first();

        $depoimentos = Depoimentos::where('status_depoimento', 'ATIVO')
        ->limit(6)
        ->inRandomOrder()
        ->get(); 


        // dd($hero);
        return view('site.home.home',compact('temas', 'dra', 'video','evento','hero','depoimentos'));
    }
}
