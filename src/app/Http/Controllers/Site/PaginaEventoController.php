<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use App\Models\Dra;

class PaginaEventoController extends Controller
{
    public function index()
    {
        $evento = Eventos::where('status_evento', 'ATIVO')
            ->first();

        $dra = Dra::where('status_dra', 'ATIVO')
            ->first();

        return view(
            'site.sessaoEvento.sessao-evento',
            compact('evento', 'dra')
        );
    }
}
