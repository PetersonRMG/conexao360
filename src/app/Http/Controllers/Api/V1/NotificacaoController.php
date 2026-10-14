<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    // =============================================================
    // LISTAR
    // =============================================================

    public function index(
        Request $request
    ): JsonResponse {

        $idUsuario =
            $request->user()
                ->id_usuario;


        $notificacoes =
            Notificacao::with([
                'usuarioOrigem:id_usuario,nome_usuario,foto_usuario'
            ])
                ->where(
                    'id_usuario_destino',
                    $idUsuario
                )
                ->orderByDesc(
                    'criado_em_notificacao'
                )
                ->get();


        return response()->json([
            'success' => true,
            'data' => $notificacoes,
        ]);
    }


    // =============================================================
    // QUANTIDADE NÃO LIDA
    // =============================================================

    public function naoLidas(
        Request $request
    ): JsonResponse {

        $quantidade =
            Notificacao::where(
                'id_usuario_destino',
                $request->user()
                    ->id_usuario
            )
                ->where(
                    'lida_notificacao',
                    false
                )
                ->count();


        return response()->json([
            'success' => true,

            'data' => [
                'quantidade' =>
                    $quantidade,
            ],
        ]);
    }


    // =============================================================
    // MARCAR UMA COMO LIDA
    // =============================================================

    public function ler(
        Request $request,
        int $idNotificacao
    ): JsonResponse {

        $notificacao =
            Notificacao::where(
                'id_notificacao',
                $idNotificacao
            )
                ->where(
                    'id_usuario_destino',
                    $request->user()
                        ->id_usuario
                )
                ->firstOrFail();


        $notificacao->update([
            'lida_notificacao' =>
                true,
        ]);


        return response()->json([
            'success' => true,
            'message' =>
                'Notificação marcada como lida.',
        ]);
    }


    // =============================================================
    // MARCAR TODAS COMO LIDAS
    // =============================================================

    public function lerTodas(
        Request $request
    ): JsonResponse {

        Notificacao::where(
            'id_usuario_destino',
            $request->user()
                ->id_usuario
        )
            ->where(
                'lida_notificacao',
                false
            )
            ->update([
                'lida_notificacao' =>
                    true,
            ]);


        return response()->json([
            'success' => true,
            'message' =>
                'Notificações marcadas como lidas.',
        ]);
    }
}