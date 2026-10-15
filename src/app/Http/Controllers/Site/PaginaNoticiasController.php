<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\NoticiasStjService;

class PaginaNoticiasController extends Controller
{
    public function index(NoticiasStjService $noticiasStjService)
    {
        return view('site.sessaoNoticias.sessao-noticias', [
            'noticias' => $noticiasStjService->listar(),
        ]);
    }

    public function show(NoticiasStjService $noticiasStjService, string $id)
    {
        // As duas páginas usam a mesma lista e as mesmas imagens em cache.
        $noticias = $noticiasStjService->listar();
        $noticia = $noticias->firstWhere('id', $id);

        abort_if($noticia === null, 404, 'Notícia não encontrada.');

        $outrasNoticias = $noticias
            ->reject(fn (array $item) => $item['id'] === $id)
            ->take(3);

        return view('site.sessaoNoticias.detalhe', [
            'noticia' => $noticia,
            'outrasNoticias' => $outrasNoticias,
        ]);
    }
}
