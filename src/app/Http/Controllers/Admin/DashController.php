<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;
use App\Models\HeroSection; 
use App\Models\Eventos;
use App\Models\Depoimentos; 
use App\Models\Usuarios;
use Illuminate\Http\Request;



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
        
        $depoimentos = Depoimentos::with(['usuario','evento'])
         ->where('status_depoimento', 'ATIVO')
         ->get();

         $usuario = Usuarios::where('status_usuario' , 'ATIVO')               
        ->get();

        
         $usuarioNovos = Usuarios::where('status_usuario' , 'ATIVO')  
         ->orderBy('criado_em_usuario', 'desc')
         ->take(5)             
        ->get();


        return view('admin.dash.controlebas', compact('evento', 'temas', 'dra', 'video', 'hero', 'depoimentos','usuario', 'usuarioNovos'));
       
    }


    /**
     * Atualiza os dados da Sessão Principal (Hero Section)
     */



    
}

