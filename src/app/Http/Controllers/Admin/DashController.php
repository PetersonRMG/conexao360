<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComentarioPublicacao;
use App\Models\Conteudo;
use App\Models\CurtidaPublicacao;
use App\Models\Denuncia;
use App\Models\Depoimentos;
use App\Models\Enquete;
use App\Models\Eventos;
use App\Models\Publicacao;
use App\Models\Resposta;
use App\Models\Usuarios;

class DashController extends Controller
{
    public function index()
    {
        // Usuários
        $totalUsuarios = Usuarios::count();
        $usuariosAtivos = Usuarios::where('status_usuario', 'ATIVO')->count();
        $novosEsteMes = Usuarios::whereYear('criado_em_usuario', now()->year)
            ->whereMonth('criado_em_usuario', now()->month)
            ->count();

        $totalPalestrantes = Usuarios::where('perfil_usuario', 'palestrante')->count();
        $palestrantesAtivos = Usuarios::where('perfil_usuario', 'palestrante')
            ->where('status_usuario', 'ATIVO')
            ->count();

        $usuariosRecentes = Usuarios::orderByDesc('criado_em_usuario')
            ->take(5)
            ->get();

        // Publicações
        $totalPublicacoes = Publicacao::count();
        $publicacoesAtivas = Publicacao::where('status_publicacao', 'ATIVO')->count();
        $publicacoesOcultas = Publicacao::where('status_publicacao', 'OCULTO')->count();

        $publicacoesRecentes = Publicacao::with(['usuario', 'evento'])
            ->orderByDesc('criado_em_publicacao')
            ->take(5)
            ->get();

        // Moderação
        $aguardandoModeracao = Denuncia::where('status_denuncia', 'PENDENTE')->count();
        $denunciasAnalisadas = Denuncia::where('status_denuncia', 'ANALISADA')->count();

        // Conteúdos / vídeos
        $totalVideos = Conteudo::where('tipo_conteudo', 'VIDEO')->count();
        $videosAtivos = Conteudo::where('tipo_conteudo', 'VIDEO')
            ->where('status_conteudo', 'ATIVO')
            ->count();

        // Enquetes
        $totalEnquetes = Enquete::count();
        $totalRespostasEnquetes = Resposta::count();

        // Eventos e depoimentos
        $totalEventos = Eventos::count();
        $totalDepoimentos = Depoimentos::count();
        $depoimentosAtivos = Depoimentos::where('status_depoimento', 'ATIVO')->count();

        // Métricas de interação do app
        $totalCurtidas = CurtidaPublicacao::count();
        $totalComentarios = ComentarioPublicacao::count();

        return view('admin.dash.controlebas', compact(
            'totalUsuarios',
            'usuariosAtivos',
            'novosEsteMes',
            'totalPalestrantes',
            'palestrantesAtivos',
            'usuariosRecentes',
            'totalPublicacoes',
            'publicacoesAtivas',
            'publicacoesOcultas',
            'publicacoesRecentes',
            'aguardandoModeracao',
            'denunciasAnalisadas',
            'totalVideos',
            'videosAtivos',
            'totalEnquetes',
            'totalRespostasEnquetes',
            'totalEventos',
            'totalDepoimentos',
            'depoimentosAtivos',
            'totalCurtidas',
            'totalComentarios'
        ));
    }
}
