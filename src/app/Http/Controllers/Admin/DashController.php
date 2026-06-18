<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class DashController extends Controller
{
  
    public function index()
    {
   

        //dd( $dra);
        return view('admin.dash.controlebas');
       
    }


    /**
     * Atualiza os dados da Sessão Principal (Hero Section)
     */



    
}

