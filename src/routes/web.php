<?php

use Illuminate\Support\Facades\Route;

// CONTROLLERS DO SITE
use App\Http\Controllers\Site\HomeController;

// CONTROLLERS DO ADMINISTRADOR
use App\Http\Controllers\Admin\DashController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DepoimentoController;
use App\Http\Controllers\Admin\ModificacoesController; // Importado o correto
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\PalestranteController;

/*
|--------------------------------------------------------------------------
| Rotas do Site Institucional
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Rotas do Painel Administrativo (Painel Conexão 360)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Visão Geral do Ecossistema (controle.blade.php / controlebas.php)
    Route::get('/', [DashController::class, 'index'])->name('dash');
    
    // Modificações do Site (content.blade.php) -> Apontado para ModificacoesController
    Route::get('/content', [ModificacoesController::class, 'content'])->name('content');
    
    // Atualizações e Criação de Conteúdo -> Ajustados para o controlador correto se necessário
    Route::post('/{id}', [ModificacoesController::class, 'update'])->name('update');
    Route::put('/criar', [ModificacoesController::class, 'create'])->name('create');
    Route::post('video/{id}', [ModificacoesController::class, 'updateVideo'])->name('updateVideo');

    // Gerenciamento de Depoimentos (Ajustado para bater com o .index do seu menu)
    Route::get('/depoimentos', [DepoimentoController::class, 'index'])->name('depoimentos.index');

    // Sistema de Mensagens Internas (Chat)
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{conversationId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // SUBGRUPO: CADASTROS (Usuários e Palestrantes)
    Route::prefix('cadastro')->name('cadastro.')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
        Route::get('/palestrantes', [PalestranteController::class, 'index'])->name('palestrantes');
    });

});








