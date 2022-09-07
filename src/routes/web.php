<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MemoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});




Route::group(['prefix' => 'book', 'as' => 'book.'], function () {
    Route::get('/', [BookController::class, 'index'])->middleware(['verified'])->name('index');
    Route::get('/search', [BookController::class, 'search'])->middleware(['auth'])->name('search');
    Route::get('/manual', [BookController::class, 'manual'])->middleware(['auth'])->name('manual');
    Route::post('/temporaryStore', [BookController::class, 'temporaryStore'])->middleware(['auth']);
    Route::get('/create', [BookController::class, 'create'])->middleware(['auth'])->name('create');
    Route::post('/store', [BookController::class, 'store'])->middleware(['auth'])->name('store');
    Route::get('/show/{book}', [BookController::class, 'show'])->name('show');
    Route::delete('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'book-memo', 'as' => 'book-memo.'], function () {
    Route::get('/{id}', [MemoController::class, 'index'])->middleware(['auth'])->name('index');
    Route::get('/create/{id}', [MemoController::class, 'create'])->middleware(['auth'])->name('create');
    Route::post('/store', [MemoController::class, 'store'])->middleware(['auth'])->name('store');
    Route::post('/update', [MemoController::class, 'update'])->middleware(['auth'])->name('update');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

require __DIR__.'/auth.php';
