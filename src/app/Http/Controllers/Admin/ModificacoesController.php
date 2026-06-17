<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Temas;
use App\Models\Dra;
use App\Models\HeroSection;

class ModificacoesController extends Controller
{
    /**
     * Exibe a página com os cartões e formulários de modificação do site
     * Aponta exatamente para resources/views/admin/dash/content.blade.php
     */
    public function index()
    {
        // Puxa todos os temas para alimentar o loop dos cartões
        $temas = Temas::all();
        
        // Puxa as informações ativas da Dra e da Hero Section
        $dra = Dra::where('status_dra', 'ATIVO')->first() ?? new Dra();
        $hero = HeroSection::first() ?? new HeroSection();

        // Variáveis utilizadas na sua view content.blade.php
        $conexao = HeroSection::first() ?? new HeroSection(); 
        $evento = HeroSection::first() ?? new HeroSection();  

        // Renderiza a view correspondente utilizando a convenção do Laravel
        return view('admin.dash.content', compact('temas', 'dra', 'hero', 'conexao', 'evento'));
    }
}