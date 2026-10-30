<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Eventos;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    public function index(): JsonResponse
    {
        // ATIVO/INATIVO sao estados do cadastro, nao datas do evento.
        // Incluimos os dois para permitir consultar edicoes anteriores.
        // ATENCAO: se INATIVO tambem significar rascunho/oculto no seu negocio,
        // crie antes um campo/regra explicita de publicacao e filtre por ela.
        $eventos = Eventos::query()
            ->select([
                'id_evento',
                'titulo_evento',
                'edicao_evento',
                'descricao_evento',
                'data_inicial_evento',
                'hora_inicial_evento',
                'data_termino_evento',
                'hora_termino_evento',
                'endereco_evento',
                'banner_evento',
            ])
            ->whereIn('status_evento', ['ATIVO', 'INATIVO'])
            ->orderByDesc('data_inicial_evento')
            ->orderByDesc('hora_inicial_evento')
            ->get()
            ->map(function (Eventos $evento): array {
                $banner = trim((string) $evento->banner_evento);

                // O painel Admin grava, por exemplo, "evento/arquivo.jpg"
                // dentro de public/conexao360/img/evento/.
                $banner = preg_replace('#^conexao360/img/#', '', ltrim($banner, '/'));

                return [
                    'id_evento' => $evento->id_evento,
                    'titulo_evento' => $evento->titulo_evento,
                    'edicao_evento' => $evento->edicao_evento,
                    'descricao_evento' => $evento->descricao_evento,
                    'data_inicial_evento' => $evento->data_inicial_evento,
                    'hora_inicial_evento' => $evento->hora_inicial_evento,
                    'data_termino_evento' => $evento->data_termino_evento,
                    'hora_termino_evento' => $evento->hora_termino_evento,
                    'endereco_evento' => $evento->endereco_evento,
                    'banner_url' => $banner !== ''
                        ? asset('conexao360/img/' . $banner)
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $eventos,
        ]);
    }
}
