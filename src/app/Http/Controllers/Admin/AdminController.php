<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function indexAdmin()
    {
        
        $perfil = Auth::user();
        
        
       
        return view('admin.dash.editar-perfil', compact('perfil'));
    }
}

