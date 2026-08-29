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
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\DraController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DepoimentosController;
use App\Http\Controllers\Admin\ModificacaoSiteController;
use App\Http\Controllers\Admin\PalestrantesController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\AdminController;



// Rota Pública do Site
Route::get('/', [HomeController::class, 'index'])->name('home');


// Rotas do Painel Administrativo
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/autenticar', [AuthController::class , 'autenticar'])->name('login.autenticar');
    Route::post('/logout',[AuthController::class , 'logout'])->name('logout');
    
    //ROTAS PROTEGIDAS
    Route::middleware('auth:admin','perfil:administrador')->group(function(){   

        // HOME DASH
        Route::get( '/',[DashController::class, 'index'] )->name('dash');
        
        //MODIFICACAO DO SITE
        Route::get( '/modificar-site',[ModificacaoSiteController::class, 'index'] )->name('modificar.site');
        
        //CREATE E UPDATE DE BANNER
        Route::put('/banner/create', [HeroController::class, 'createHero'])->name('hero.create');
        Route::put('/banner/update{id}', [HeroController::class, 'updateHero'])->name('hero.update');
    
        //CREATE E UPDATE DE TEMA
        Route::put( '/tema/create',[TemasController::class, 'createTema']  )->name('tema.create');
        Route::put( '/tema/update{id}',[TemasController::class, 'updateTema']  )->name('tema.update');
        
        //CREATE E UPDATE DE EVENTO
        Route::put('/evento/create', [EventoController::class, 'createEvento'])->name('evento.create');
        Route::put('/evento/update{id}', [EventoController::class, 'updateEvento'])->name('evento.update');
        
        //CREATE E UPDATE DE VIDEO
        Route::put('/video/create', [VideoController::class, 'createVideo'])->name('video.create');
        Route::put('/video/update{id}', [VideoController::class, 'updateVideo'])->name('video.update');
        
        //CREATE E UPDATE DE DRA
        Route::put('/dra/create', [DraController::class, 'createDra'])->name('dra.create');
        Route::put('/dra/update{id}', [DraController::class, 'updateDra'])->name('dra.update');
        
        //ROTAS DE DEPOIMENTO
        Route::get('/depoimentos', [DepoimentosController::class, 'indexAdmin'])->name('depoimentos.index');
        Route::put('/depoimentos/aceitar{id}', [DepoimentosController::class, 'DepoAceitar'])->name('depoimentos.aceitar');
        Route::put('/depoimentos/recusar{id}', [DepoimentosController::class, 'DepoRecusar'])->name('depoimentos.recusar');

        //ROTA EDITAR PERFIL
        Route::get('/perfil', [AdminController::class, 'indexAdmin'])->name('perfil');
        Route::put('/perfil', [AdminController::class, 'updateAdmin'])->name('perfil.update');
        
        
        Route::get('/palestrantes', [PalestrantesController::class, 'index'])->name('palestrantes');
        Route::get('/palestrantes/cadastro', [PalestrantesController::class, 'palestrante'])->name('cadastro.palestrante');
        Route::put('/palestrantes/create', [PalestrantesController::class, 'createPalestrante'])->name('palestrante.create');
        Route::put('/palestrantes/update{id}', [PalestrantesController::class, 'updatePalestrante'])->name('palestrante.update');
        Route::patch('/palestrantes/{id}/ativar', [PalestrantesController::class,'ativar'])->name('palestrante.ativar');
        Route::patch('/palestrantes/{id}/desativar', [PalestrantesController::class,'desativar'])->name('palestrante.desativar');

        Route::get('/usuarios', [UsuariosController::class, 'index'])->name('cadastro.usuarios');        
        
        
        Route::put('/lista/update', [FormularioController::class, 'update'])->name('admin.lista.update'); 
        Route::put('/conexao/update', [ConexaoController::class, 'update'])->name('admin.conexao.update');   
    });

    Route::prefix('palestrante')->middleware(['auth:admin','perfil:palestrante'])->group(function () {
        //HOME PALESTRANTE
        Route::get('/', [PalestrantesController::class, 'index'])->name('palestrante.dash');

        //DEPOIMENTO PALESTRANTE
        Route::get('/depoimentos', [DepoimentosController::class, 'indexPalestrante'])->name('palestrante.depoimento.index');
         Route::put('/depoimentos', [DepoimentosController::class, 'createDepoimento'])->name('palestrante.depoimento.create');

    });


     
});




