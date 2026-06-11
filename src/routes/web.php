<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;


use App\Http\Controllers\Admin\DashController;
use App\Http\Controllers\Admin\ConexaoController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\FormularioController;
use App\Models\HeroController;


// Rota Pública do Site
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas do Painel Administrativo
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get( '/',[DashController::class, 'index'] )->name('dash');

    Route::put('/home/update', [DashController::class, 'updateHero'])  ->name('updateHero');

    Route::put( '/update/{id}',[DashController::class, 'update']  )->name('update');

    Route::put('/evento/update', [EventoController::class, 'update'])->name('evento.update');

    Route::put('/hero/update', [DataController::class, 'update'])->name('hero.update');


    Route::put('/lista/update', [FormularioController::class, 'update'])->name('admin.lista.update');

    
    Route::post('video/{id}', [DashController::class,'updateVideo'])->name('updateVideo');
    Route::put('/dra/update', [SobreDraController::class, 'update'])->name('dra.update');
    
    
    Route::put('/conexao/update', [ConexaoController::class, 'update'])->name('admin.conexao.update');




    Route::put('/criar', [DashController::class,'create'])->name('create');


    

});




