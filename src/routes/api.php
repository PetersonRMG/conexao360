<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\UsuarioController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProdutoController;


Route::prefix('v1')->group(function () {

    Route::get('/status', [StatusController::class, 'index']);
    
    Route::get('/usuario', [UsuarioController::class, 'index']);

    
});