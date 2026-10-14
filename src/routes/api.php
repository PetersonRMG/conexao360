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


Route::prefix('v1')->group(function () {

    // ==============================
    // PÚBLICAS
    // ==============================

    Route::get('/status', [
        StatusController::class,
        'index'
    ]);


    Route::post('/auth/login', [
        AuthController::class,
        'login'
    ]);


    // ==============================
    // PROTEGIDAS
    // ==============================

    Route::middleware('auth:sanctum')->group(function () {


        // USUÁRIO LOGADO

        Route::get('/usuario', [
            UsuarioController::class,
            'show'
        ]);


        // PERFIL DE USUÁRIO

        Route::get(
            '/usuarios/{idUsuario}',
            [
                PerfilController::class,
                'show'
            ]
        );


        // PUBLICAÇÕES

        Route::get('/publicacoes', [
            PublicacaoController::class,
            'index'
        ]);


        // CURTIDAS

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


        // COMENTÁRIOS

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

        Route::post('/publicacoes', [
            PublicacaoController::class,
            'store'
        ]);


        // CONEXÕES

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


        // LOGOUT

        Route::post('/auth/logout', [
            AuthController::class,
            'logout'
        ]);

    });
});