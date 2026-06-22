<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SITE CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\EnqueteController;
use App\Http\Controllers\Site\NetworkController;
use App\Http\Controllers\Site\FeedController;
use App\Http\Controllers\Site\FeedLikeController;
use App\Http\Controllers\Site\FeedComentarioController;
use App\Http\Controllers\Site\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

/*
|--------------------------------------------------------------------------
| ENQUETE
|--------------------------------------------------------------------------
*/

Route::get(
    '/enquete',
    [EnqueteController::class, 'enquete']
)->name('enquete');

/*
|--------------------------------------------------------------------------
| NETWORK
|--------------------------------------------------------------------------
*/

Route::get(
    '/network',
    [NetworkController::class, 'index']
)->name('network');

/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/

Route::get(
    '/network/profile/edit',
    [ProfileController::class, 'edit']
)->name('network.profile.edit');

Route::post(
    '/network/profile/update',
    [ProfileController::class, 'update']
)->name('network.profile.update');

Route::get(
    '/network/profile/{id}',
    [ProfileController::class, 'show']
)->name('network.profile');

/*
|--------------------------------------------------------------------------
| FEEDS
|--------------------------------------------------------------------------
*/

Route::post(
    '/network/feed/store',
    [FeedController::class, 'store']
)->name('network.feed.store');

Route::get(
    '/network/feed/{id}/edit',
    [FeedController::class, 'edit']
)->name('network.feed.edit');

Route::put(
    '/network/feed/{id}',
    [FeedController::class, 'update']
)->name('network.feed.update');

Route::delete(
    '/network/feed/{id}',
    [FeedController::class, 'destroy']
)->name('network.feed.destroy');

/*
|--------------------------------------------------------------------------
| CURTIDAS
|--------------------------------------------------------------------------
*/

Route::post(
    '/network/feed/{id}/like',
    [FeedLikeController::class, 'toggle']
)->name('network.feed.like');

/*
|--------------------------------------------------------------------------
| COMENTÁRIOS
|--------------------------------------------------------------------------
*/

Route::post(
    '/network/comment/store',
    [FeedComentarioController::class, 'store']
)->name('network.comment.store');

Route::delete(
    '/network/comment/{id}',
    [FeedComentarioController::class, 'destroy']
)->name('network.comment.destroy');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/',
            [DashController::class, 'index']
        )->name('dash');

        Route::post(
            '/{id}',
            [DashController::class, 'update']
        )->name('update');

        Route::put(
            '/criar',
            [DashController::class, 'create']
        )->name('create');

        Route::post(
            '/video/{id}',
            [DashController::class, 'updateVideo']
        )->name('updateVideo');

    });