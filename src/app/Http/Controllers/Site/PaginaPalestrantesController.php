<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;

class PaginaPalestrantesController extends Controller
{
    public function index()
    {
        $palestrantes = Usuarios::where(
            'perfil_usuario',
            'palestrante'
        )
            ->where(
                'status_usuario',
                'ATIVO'
            )
            ->orderBy(
                'nome_usuario'
            )
            ->get();

        return view(
            'site.sessaoPalestrantes.sessao-palestrantes',
            compact('palestrantes')
        );
    }


    public function show(int $id)
    {
        $palestrante = Usuarios::where(
            'perfil_usuario',
            'palestrante'
        )
            ->where(
                'status_usuario',
                'ATIVO'
            )
            ->where(
                'id_usuario',
                $id
            )
            ->firstOrFail();

        return view(
            'site.sessaoPalestrantes.perfil-palestrante',
            compact('palestrante')
        );
    }
}
