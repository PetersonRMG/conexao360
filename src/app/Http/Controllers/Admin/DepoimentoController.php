<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepoimentoController extends Controller
{
    public function index()
    {
        // Aponta exatamente para resources/views/admin/dash/Depoimentos.blade.php
        return view('admin.dash.depoimentos');
    }
}