<?php

use App\Http\Controllers\BookController;
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

Route::get('/book', [BookController::class, 'index'])->middleware(['verified'])->name('book.index');
Route::get('/book/search', [BookController::class, 'search'])->middleware(['auth'])->name('book.search');
Route::get('/book/manual', [BookController::class, 'manual'])->middleware(['auth'])->name('book.manual');
Route::post('/book/temporaryStore', [BookController::class, 'temporaryStore'])->middleware(['auth']);
Route::get('/book/create', [BookController::class, 'create'])->middleware(['auth'])->name('book.create');
Route::post('/book/store', [BookController::class, 'store'])->middleware(['auth'])->name('book.store');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

require __DIR__.'/auth.php';
