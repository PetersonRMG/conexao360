<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\UsuarioController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PublicacaoController;

Route::prefix('v1')->group(function () {

    Route::get('/status', [StatusController::class, 'index']);

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/usuario', [UsuarioController::class, 'show']);

        Route::get('/publicacoes', [PublicacaoController::class, 'index']);

        Route::post('/auth/logout', [AuthController::class, 'logout']);
    });
});
