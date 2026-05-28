<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Temas;
use App\Models\Dra;
use App\Models\Video;


class DashController extends Controller
{
    //
    public function index(){
        $temas = Temas::where('status_tema', 'ATIVO')
        ->inRandomOrder()        
        ->get();

        $dra = Dra::where('status_dra', 'ATIVO')               
        ->get();

        $video = Video::where('status_video', 'ATIVO')               
        ->get();

            //dd( $video);
        return view('admin/dash/dashboard',compact('temas', 'dra', 'video'));
       
    }
}
