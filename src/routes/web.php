<?php
// SITE

use App\Http\Controllers\Site\HomeController;

//ADMIN

use App\Http\Controllers\Admin\DashController;

use Illuminate\Support\Facades\Route;


Route::get('/',  [HomeController::class,'index'])->name('home');



Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/',[DashController::class,'index'])->name('dash');
});


Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [DashController::class, 'index'])->name('dash');
    
    // Nova rota para salvar as alterações da página principal (com foto)
    Route::post('/pagina-principal/update', [DashController::class, 'updatePaginaPrincipal'])->name('pagina_principal.update');
});