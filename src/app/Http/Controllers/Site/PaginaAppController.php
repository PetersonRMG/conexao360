<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
 

class PaginaAppController extends Controller
{
    public function index()
    {


        return view('site.sessaoApp.sessao-app');
    }
}
