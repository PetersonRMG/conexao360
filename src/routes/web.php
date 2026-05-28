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