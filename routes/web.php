<?php

use App\Http\Controllers\WritterController as Writter;
use App\Http\Controllers\CopyWritterController as Copy;
use App\Http\Controllers\MerkController as Merk;
use App\Http\Controllers\ClientsController as Clients;
use Illuminate\Support\Facades\Route;


/*------------------------------------
| Writter Routes
--------------------------------------*/

Route::group([
    'prefix' => 'writter',
], function () {
    // Auth Writter Routes
    Route::get('login', [Writter::class, 'login'])->name('writter.login');
    Route::post('login', [Writter::class, 'loginPost'])->name('writter.login');
    Route::group(['middleware' => ['writter']], function () {
        Route::get('/dashboard', [Writter::class, 'dashboard'])->name('writter.dashboard');
        Route::get('/logout', [Writter::class, 'logout'])->name('writter.logout');
        Route::get('/copywrite', [Copy::class, 'index'])->name('writter.product');

        // Copywrite Routes
        Route::get('/copywrite/insert', [Copy::class, 'insert'])->name('writter.product.insert');
        Route::post('/copywrite/insert', [Copy::class, 'insertPost'])->name('writter.product.insert');
        Route::get('/copywrite/edit/{id}', [Copy::class, 'edit'])->name('writter.product.edit');
        Route::post('/copywrite/edit/{id}', [Copy::class, 'editPost'])->name('writter.product.edit');
        Route::post('/copywrite/image/delete', [Copy::class, 'deleteImg'])->name('writter.product.image.delete');

        // Merk Routes
        Route::get('/merk', [Merk::class, 'index'])->name('writter.merk');
        Route::post('/merk', [Merk::class, 'insert'])->name('writter.merk.insert');
        Route::post('/merk/delete', [Merk::class, 'delete'])->name('writter.merk.delete');
        Route::post('/merk/edit', [Merk::class, 'edit'])->name('writter.merk.edit');
    });
});

Route::get('/', [Clients::class, 'index'])->name('clients.index');
Route::get('/search/{name?}', [Clients::class, 'searchIndex'])->name('clients.search.index');
Route::get('/produk/detail/{id}', [Clients::class, 'detail'])->name('clients.detail');
Route::post('/search', [Clients::class, 'query'])->name('clients.search.query');
Route::get('/test', [Clients::class, 'test'])->name('clients.test');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
