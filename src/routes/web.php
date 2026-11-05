<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PaginaAppController;
use App\Http\Controllers\Site\PaginaPalestrantesController;
use App\Http\Controllers\Site\PaginaNoticiasController;
use App\Http\Controllers\Site\PaginaEventoController;
use App\Http\Controllers\Site\ApiDocumentationController;




use App\Http\Controllers\Admin\DashController;
use App\Http\Controllers\Admin\ConexaoController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\ConteudoEventoController;

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
use App\Http\Controllers\Admin\PerfilPalestranteController;
use App\Http\Controllers\Admin\PublicacaoController;
use App\Http\Controllers\Admin\ModeracaoController;
use App\Http\Controllers\Admin\ConteudosController;
use App\Http\Controllers\Admin\EnquetesController;





// Rota Pública do Site
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/page-app', [PaginaAppController::class, 'index'])->name('page-app');
Route::get('/page-palestrantes', [PaginaPalestrantesController::class, 'index'])->name('page-palestrantes');
Route::get('/page-noticias', [PaginaNoticiasController::class, 'index'])->name('page-noticias');
Route::get('/page-noticias/{id}', [PaginaNoticiasController::class, 'show'])->where('id', '[a-f0-9]{40}')->name('page-noticias.show');
Route::get('/page-evento', [PaginaEventoController::class, 'index'])->name('page-evento');
Route::get('/page-palestrantes/{id}', [PaginaPalestrantesController::class, 'show'])->whereNumber('id')->name('page-palestrante');



// Rotas do Painel Administrativo
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/autenticar', [AuthController::class, 'autenticar'])->name('login.autenticar');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //ROTAS PROTEGIDAS
    Route::middleware('auth:admin', 'perfil:administrador')->group(function () {

        // HOME DASH
        Route::get('/', [DashController::class, 'index'])->name('dash');

        //MODIFICACAO DO SITE
        Route::get('/modificar-site', [ModificacaoSiteController::class, 'index'])->name('modificar.site');

        //CREATE E UPDATE DE BANNER
        Route::put('/banner/create', [HeroController::class, 'createHero'])->name('hero.create');
        Route::put('/banner/update{id}', [HeroController::class, 'updateHero'])->name('hero.update');

        //CREATE E UPDATE DE TEMA
        Route::put('/tema/create', [TemasController::class, 'createTema'])->name('tema.create');
        Route::put('/tema/update{id}', [TemasController::class, 'updateTema'])->name('tema.update');

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
        Route::patch('/palestrantes/{id}/ativar', [PalestrantesController::class, 'ativar'])->name('palestrante.ativar');
        Route::patch('/palestrantes/{id}/desativar', [PalestrantesController::class, 'desativar'])->name('palestrante.desativar');

        Route::get('/usuarios', [UsuariosController::class, 'index'])->name('cadastro.usuarios');



        Route::put('/conexao/update', [ConexaoController::class, 'update'])->name('admin.conexao.update');

        // PUBLICAÇÕES
        Route::get('/publicacoes', [PublicacaoController::class, 'index'])->name('publicacoes.index');

        Route::post('/publicacoes', [PublicacaoController::class, 'store'])->name('publicacoes.store');

        Route::patch('/publicacoes/{id}/status', [PublicacaoController::class, 'status'])->name('publicacoes.status');

        // CONTEÚDOS / VÍDEOS
        Route::get('/conteudos', fn () => redirect()->route('admin.eventos.index'))->name('conteudos.index');

        Route::get('/conteudos/videos', fn () => redirect()->route('admin.eventos.index'))->name('conteudos.videos');

        // Cadastro de vídeo do administrador ocorre em /eventos/{idEvento}/videos.

        Route::patch('/conteudos/videos/{id}/status', [ConteudosController::class, 'statusVideo'])->name('conteudos.videos.status');

        // ENQUETES
        Route::get('/enquetes', fn () => redirect()->route('admin.eventos.index'))->name('enquetes.index');

        // Cadastro de enquete do administrador ocorre em /eventos/{idEvento}/enquetes.


        // MODERAÇÃO / DENÚNCIAS
        Route::get('/moderacao', [ModeracaoController::class, 'index'])->name('moderacao.index');

        Route::patch('/moderacao/{id}/analisar', [ModeracaoController::class, 'analisar'])->name('moderacao.analisar');


        // EVENTOS: manutenção centralizada, sem telas independentes para vídeos/enquetes.
        Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
        Route::get('/eventos/novo', [EventoController::class, 'novo'])->name('eventos.novo');
        Route::get('/eventos/{idEvento}/editar', [EventoController::class, 'editar'])
            ->whereNumber('idEvento')->name('eventos.editar');

        // GERENCIAR CONTEÚDO DOS EVENTOS
        Route::get('/eventos/{idEvento}/conteudo',[ConteudoEventoController::class, 'show'])->whereNumber('idEvento')->name('eventos.conteudo');

        Route::post('/eventos/{idEvento}/albuns',[ConteudoEventoController::class, 'criarAlbum']  )->whereNumber('idEvento')->name('eventos.albuns.store');

        Route::post('/eventos/{idEvento}/albuns/{idAlbum}/fotos',[ConteudoEventoController::class, 'enviarFoto']
        )->whereNumber('idEvento')
            ->whereNumber('idAlbum')
            ->name('eventos.fotos.store');

        // Edição e exclusão dos álbuns e fotos, sempre escopadas ao evento.
        Route::put('/eventos/{idEvento}/albuns/{idAlbum}', [ConteudoEventoController::class, 'atualizarAlbum'])
            ->whereNumber('idEvento')->whereNumber('idAlbum')->name('eventos.albuns.update');
        Route::delete('/eventos/{idEvento}/albuns/{idAlbum}', [ConteudoEventoController::class, 'excluirAlbum'])
            ->whereNumber('idEvento')->whereNumber('idAlbum')->name('eventos.albuns.destroy');
        Route::put('/eventos/{idEvento}/albuns/{idAlbum}/fotos/{idFoto}', [ConteudoEventoController::class, 'atualizarFoto'])
            ->whereNumber('idEvento')->whereNumber('idAlbum')->whereNumber('idFoto')->name('eventos.fotos.update');
        Route::delete('/eventos/{idEvento}/albuns/{idAlbum}/fotos/{idFoto}', [ConteudoEventoController::class, 'excluirFoto'])
            ->whereNumber('idEvento')->whereNumber('idAlbum')->whereNumber('idFoto')->name('eventos.fotos.destroy');

        // Vídeos cadastrados diretamente no evento (URLs externas).
        Route::post('/eventos/{idEvento}/videos', [ConteudoEventoController::class, 'criarVideo'])
            ->whereNumber('idEvento')->name('eventos.videos.store');
        Route::patch('/eventos/{idEvento}/videos/{idVideo}/status', [ConteudoEventoController::class, 'alterarStatusVideo'])
            ->whereNumber('idEvento')->whereNumber('idVideo')->name('eventos.videos.status');

        Route::put('/eventos/{idEvento}/videos/{idVideo}', [ConteudoEventoController::class, 'atualizarVideo'])
            ->whereNumber('idEvento')->whereNumber('idVideo')->name('eventos.videos.update');
        Route::delete('/eventos/{idEvento}/videos/{idVideo}', [ConteudoEventoController::class, 'excluirVideo'])
            ->whereNumber('idEvento')->whereNumber('idVideo')->name('eventos.videos.destroy');

        // Enquetes são mantidas em tbl_enquetes, agora vinculadas ao evento.
        Route::post('/eventos/{idEvento}/enquetes', [ConteudoEventoController::class, 'criarEnquete'])
            ->whereNumber('idEvento')->name('eventos.enquetes.store');
        Route::patch('/eventos/{idEvento}/enquetes/{idEnquete}/status', [ConteudoEventoController::class, 'alterarStatusEnquete'])
            ->whereNumber('idEvento')->whereNumber('idEnquete')->name('eventos.enquetes.status');

        Route::post('/eventos/{idEvento}/enquetes/vincular', [ConteudoEventoController::class, 'vincularEnquete'])
            ->whereNumber('idEvento')->name('eventos.enquetes.vincular');

        Route::put('/eventos/{idEvento}/enquetes/{idEnquete}', [ConteudoEventoController::class, 'atualizarEnquete'])
            ->whereNumber('idEvento')->whereNumber('idEnquete')->name('eventos.enquetes.update');
        Route::delete('/eventos/{idEvento}/enquetes/{idEnquete}', [ConteudoEventoController::class, 'excluirEnquete'])
            ->whereNumber('idEvento')->whereNumber('idEnquete')->name('eventos.enquetes.destroy');

        // Programação por evento, com edição e inativação sem excluir histórico.
        Route::post('/eventos/{idEvento}/programacao', [ConteudoEventoController::class, 'criarProgramacao'])
            ->whereNumber('idEvento')->name('eventos.programacao.store');
        Route::put('/eventos/{idEvento}/programacao/{idProgramacao}', [ConteudoEventoController::class, 'atualizarProgramacao'])
            ->whereNumber('idEvento')->whereNumber('idProgramacao')->name('eventos.programacao.update');
        Route::patch('/eventos/{idEvento}/programacao/{idProgramacao}/status', [ConteudoEventoController::class, 'alterarStatusProgramacao'])
            ->whereNumber('idEvento')->whereNumber('idProgramacao')->name('eventos.programacao.status');
    });

    Route::prefix('palestrante')->middleware(['auth:admin', 'perfil:palestrante'])->group(function () {
        //HOME PALESTRANTE
        Route::get('/', [PalestrantesController::class, 'index'])->name('palestrante.dash');

        //DEPOIMENTO PALESTRANTE
        Route::get('/depoimentos', [DepoimentosController::class, 'indexPalestrante'])->name('palestrante.depoimento.index');
        Route::put('/depoimentos', [DepoimentosController::class, 'createDepoimento'])->name('palestrante.depoimento.create');
        Route::get('/perfil', [PerfilPalestranteController::class, 'index'])->name('palestrante.perfil.index');

        Route::put('/perfil', [PerfilPalestranteController::class, 'update'])->name('palestrante.perfil.update');

        // ========================================
        // PUBLICAÇÕES DO PALESTRANTE
        // ========================================

        Route::get(
            '/publicacoes',
            [PublicacaoController::class, 'indexPalestrante']
        )->name('palestrante.publicacoes.index');

        Route::post(
            '/publicacoes',
            [PublicacaoController::class, 'storePalestrante']
        )->name('palestrante.publicacoes.store');

        Route::patch(
            '/publicacoes/{id}/status',
            [PublicacaoController::class, 'statusPalestrante']
        )->name('palestrante.publicacoes.status');

        // VÍDEOS DAS PALESTRAS
        Route::get('/videos', [ConteudosController::class, 'videosPalestrante'])->name('palestrante.video.index');

        Route::post('/videos', [ConteudosController::class, 'storeVideoPalestrante'])->name('palestrante.video.store');

        Route::patch('/videos/{id}/status', [ConteudosController::class, 'statusVideoPalestrante'])->name('palestrante.video.status');


        // ENQUETES DO PALESTRANTE
        Route::get('/enquetes', [EnquetesController::class, 'indexPalestrante'])->name('palestrante.enquete.index');

        Route::post('/enquetes', [EnquetesController::class, 'storePalestrante'])->name('palestrante.enquete.store');


    });
});

Route::get(
    '/api/documentacao',
    [ApiDocumentationController::class, 'index']
)->name('api.documentacao');
