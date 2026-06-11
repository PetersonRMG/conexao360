<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;


use App\Http\Controllers\Admin\DashController;
use App\Http\Controllers\Admin\ConexaoController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\FormularioController;
use App\Http\Controllers\Admin\TemasController;
use App\Http\Controllers\Admin\HeroController;



// Rota Pública do Site
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas do Painel Administrativo
Route::prefix('admin')->name('admin.')->group(function () {
    // HOME DASH
    Route::get( '/',[DashController::class, 'index'] )->name('dash');

    //CREATE E UPDATE DE BANNER
    Route::put('/create-banner', [HeroController::class, 'createHero'])->name('createHero');
    Route::put('/update-banner/{id}', [HeroController::class, 'updateHero'])->name('updateHero');

     //CREATE E UPDATE DE TEMA
    Route::put( '/create-tema',[TemasController::class, 'createTema']  )->name('create-tema');
    Route::put( '/update-tema/{id}',[TemasController::class, 'updateTema']  )->name('update-tema');

    //CREATE E UPDATE DE EVENTO
    Route::put('/evento/update', [EventoController::class, 'update'])->name('evento.update');
    Route::put('/hero/update', [DataController::class, 'update'])->name('hero.update');


    Route::put('/lista/update', [FormularioController::class, 'update'])->name('admin.lista.update');
    

    Route::put('video/{id}', [DashController::class,'updateVideo'])->name('updateVideo');
    Route::put('/dra/update', [SobreDraController::class, 'update'])->name('dra.update');
    
    
    Route::put('/conexao/update', [ConexaoController::class, 'update'])->name('admin.conexao.update');




    Route::put('/criar', [DashController::class,'create'])->name('create');


    

});




