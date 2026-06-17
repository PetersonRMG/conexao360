<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PalestranteController extends Controller
{
    public function index()
    {
        // Alterado de 'palestrantes' para 'palestrante' (no singular)
        return view('admin.cadastro.palestrante');
    }
}