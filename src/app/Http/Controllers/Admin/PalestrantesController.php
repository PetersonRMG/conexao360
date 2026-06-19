<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PalestrantesController extends Controller
{
    //
    public function index(){
        return view('palestrante.dashPalestrante.dashboard');
    }
}
