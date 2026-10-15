<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Temas;
use App\Models\Dra;
use App\Models\Eventos;
use App\Models\HeroSection;
use App\Models\Depoimentos;
use App\Models\Usuarios;
use App\Services\NoticiasStjService;

class HomeController extends Controller
{
    public function index(NoticiasStjService $noticiasStjService)
    {
        $temas = Temas::where('status_tema', 'ATIVO')
            ->inRandomOrder()
            ->get();

        $dra = Dra::where('status_dra', 'ATIVO')
            ->get();

        // O carousel da Home trabalha com no máximo 3 banners ativos.
        $hero = HeroSection::where('status_hero', 'ATIVO')
            ->limit(3)
            ->get();

        $evento = Eventos::where('status_evento', 'ATIVO')
            ->first();

        $depoimentos = Depoimentos::where('status_depoimento', 'ATIVO')
            ->limit(6)
            ->inRandomOrder()
            ->get();

        // Palestrantes cadastrados no mesmo model de usuários.
        $palestrantes = Usuarios::where('perfil_usuario', 'palestrante')
            ->where('status_usuario', 'ATIVO')
            ->orderByDesc('criado_em_usuario')
            ->limit(4)
            ->get();

        // Mesma origem, imagens e cache da página Conexão Jurídica.
        // A consulta ao RSS só acontece quando o cache expira.
        $noticiasHome = $noticiasStjService->listar()->take(3);

        return view('site.home.home', compact(
            'temas',
            'dra',
            'evento',
            'hero',
            'depoimentos',
            'palestrantes',
            'noticiasHome'
        ));
    }
}
