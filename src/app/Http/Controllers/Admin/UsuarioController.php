<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        // Aqui você pode buscar os usuários do banco se quiser listá-los
        // $usuarios = User::all();
        
        return view('admin.cadastro.usuarios');
    }
}