<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\UsuarioController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PublicacaoController;
use App\Http\Controllers\Api\V1\CurtidaPublicacaoController;
use App\Http\Controllers\Api\V1\ComentarioPublicacaoController;
use App\Http\Controllers\Api\V1\ConexaoController;
use App\Http\Controllers\Api\V1\PerfilController;
use App\Http\Controllers\Api\V1\NotificacaoController;
use App\Http\Controllers\Api\V1\ConversaController;
use App\Http\Controllers\Api\V1\DenunciaPublicacaoController;
use App\Http\Controllers\Api\V1\EnqueteController;


Route::prefix('v1')->group(function () {

    // =============================================================
    // ROTAS PÚBLICAS
    // =============================================================

    Route::get(
        '/status',
        [
            StatusController::class,
            'index'
        ]
    );


    // LOGIN

    Route::post(
        '/auth/login',
        [
            AuthController::class,
            'login'
        ]
    );


    // CADASTRO

    Route::post(
        '/auth/register',
        [
            AuthController::class,
            'register'
        ]
    );


    // =============================================================
    // ROTAS PROTEGIDAS
    // =============================================================

    Route::middleware(
        'auth:sanctum'
    )->group(function () {


        // =========================================================
        // USUÁRIO LOGADO
        // =========================================================

        Route::get(
            '/usuario',
            [
                UsuarioController::class,
                'show'
            ]
        );


        // =========================================================
        // PERFIL DE USUÁRIO
        // =========================================================

        Route::get(
            '/usuarios/{idUsuario}',
            [
                PerfilController::class,
                'show'
            ]
        );


        // =========================================================
        // PUBLICAÇÕES
        // =========================================================

        Route::get(
            '/publicacoes',
            [
                PublicacaoController::class,
                'index'
            ]
        );


        Route::post(
            '/publicacoes',
            [
                PublicacaoController::class,
                'store'
            ]
        );


        // =========================================================
        // CURTIDAS
        // =========================================================

        Route::post(
            '/publicacoes/{id}/curtidas',
            [
                CurtidaPublicacaoController::class,
                'store'
            ]
        );


        Route::delete(
            '/publicacoes/{id}/curtidas',
            [
                CurtidaPublicacaoController::class,
                'destroy'
            ]
        );


        // =========================================================
        // COMENTÁRIOS
        // =========================================================

        Route::get(
            '/publicacoes/{id}/comentarios',
            [
                ComentarioPublicacaoController::class,
                'index'
            ]
        );


        Route::post(
            '/publicacoes/{id}/comentarios',
            [
                ComentarioPublicacaoController::class,
                'store'
            ]
        );


        // =========================================================
        // CONEXÕES
        // =========================================================

        Route::get(
            '/conexoes',
            [
                ConexaoController::class,
                'index'
            ]
        );


        Route::get(
            '/conexoes/solicitacoes',
            [
                ConexaoController::class,
                'solicitacoes'
            ]
        );


        Route::get(
            '/conexoes/enviadas',
            [
                ConexaoController::class,
                'enviadas'
            ]
        );


        Route::post(
            '/conexoes/{idUsuario}',
            [
                ConexaoController::class,
                'store'
            ]
        );


        Route::patch(
            '/conexoes/{idConexao}/aceitar',
            [
                ConexaoController::class,
                'aceitar'
            ]
        );


        Route::patch(
            '/conexoes/{idConexao}/recusar',
            [
                ConexaoController::class,
                'recusar'
            ]
        );


        Route::delete(
            '/conexoes/{idConexao}',
            [
                ConexaoController::class,
                'destroy'
            ]
        );


        // =========================================================
        // CONVERSAS / CHAT
        // =========================================================

        // LISTAR CONVERSAS DO USUÁRIO

        Route::get(
            '/conversas',
            [
                ConversaController::class,
                'index'
            ]
        );


        // ABRIR OU CRIAR CONVERSA COM UM USUÁRIO

        Route::post(
            '/conversas/{idUsuario}',
            [
                ConversaController::class,
                'store'
            ]
        );


        // LISTAR MENSAGENS DA CONVERSA

        Route::get(
            '/conversas/{idConversa}/mensagens',
            [
                ConversaController::class,
                'mensagens'
            ]
        );


        // ENVIAR MENSAGEM

        Route::post(
            '/conversas/{idConversa}/mensagens',
            [
                ConversaController::class,
                'enviarMensagem'
            ]
        );


        // =========================================================
        // NOTIFICAÇÕES
        // =========================================================

        Route::get(
            '/notificacoes',
            [
                NotificacaoController::class,
                'index'
            ]
        );


        Route::get(
            '/notificacoes/nao-lidas',
            [
                NotificacaoController::class,
                'naoLidas'
            ]
        );


        Route::patch(
            '/notificacoes/ler-todas',
            [
                NotificacaoController::class,
                'lerTodas'
            ]
        );


        Route::patch(
            '/notificacoes/{idNotificacao}/ler',
            [
                NotificacaoController::class,
                'ler'
            ]
        );


        // =========================================================
        // LOGOUT
        // =========================================================

        Route::post(
            '/auth/logout',
            [
                AuthController::class,
                'logout'
            ]
        );

        Route::put(
            '/usuario',
            [UsuarioController::class, 'update']
        );

        Route::post(
            '/publicacoes/{id}/denuncias',
            [DenunciaPublicacaoController::class, 'store']
        );

        Route::delete(
            '/publicacoes/{id}',
            [PublicacaoController::class, 'destroy']
        );

        // =========================================================
// PESQUISA DE USUÁRIOS
// =========================================================

        Route::get(
            '/usuarios',
            [
                UsuarioController::class,
                'index'
            ]
        );


        // =========================================================
// PERFIL DE USUÁRIO
// =========================================================

        Route::get(
            '/usuarios/{idUsuario}',
            [
                PerfilController::class,
                'show'
            ]
        );

        // =========================================================
// ENQUETES
// =========================================================

Route::get(
    '/enquetes',
    [
        EnqueteController::class,
        'index'
    ]
);


Route::post(
    '/enquetes/{idEnquete}/resposta',
    [
        EnqueteController::class,
        'responder'
    ]
)->whereNumber('idEnquete');



    });
});