<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\MemoGroupController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'book', 'as' => 'book.'], function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/search', [BookController::class, 'search'])->name('search');
        Route::get('/manual', [BookController::class, 'manual'])->name('manual');
        Route::post('/temporaryStore', [BookController::class, 'temporaryStore']);
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/store', [BookController::class, 'store'])->name('store');
        Route::get('/show/{book}', [BookController::class, 'show'])->name('show');
        Route::delete('/destroy/{book}', [BookController::class, 'destroy'])->name('destroy');
        Route::get('/update/{book}', [BookController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'book-memo', 'as' => 'book-memo.'], function () {
        Route::get('/show/{id}', [MemoController::class, 'show'])->name('show');
        Route::post('/store', [MemoController::class, 'store'])->name('store');
        Route::patch('/update/{id}', [MemoController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'book-memo'], function () {
        Route::get('before/edit/{id}', [MemoController::class, 'edit'])->name('book-memo-before.edit');
        Route::get('during/edit/{id}', [MemoController::class, 'edit'])->middleware(['check.book-memo'])->name('book-memo-during.edit');
        Route::get('after/edit/{id}', [MemoController::class, 'edit'])->middleware(['check.book-memo'])->name('book-memo-after.edit');
    });

    Route::group(['prefix' => 'action-list', 'as' => 'action-list.'], function () {
        Route::get('/show/{id}', [MemoController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [MemoController::class, 'edit'])->middleware(['check.edit-action-list'])->name('edit');
        Route::post('/store', [MemoController::class, 'store'])->middleware(['check.store-action-list'])->name('store');
        Route::patch('/update/{id}', [MemoController::class, 'update'])->middleware(['check.store-action-list'])->name('update');
    });

    Route::group(['prefix' => 'feedback-list', 'as' => 'feedback-list.'], function () {
        Route::get('/show/{id}', [MemoController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [MemoController::class, 'edit'])->middleware(['check.edit-feedback-list'])->name('edit');
        Route::post('/store', [MemoController::class, 'store'])->middleware(['check.store-feedback-list'])->name('store');
        Route::patch('/update/{id}', [MemoController::class, 'update'])->middleware(['check.store-feedback-list'])->name('update');
    });

    Route::group(['prefix' => 'user-name', 'as' => 'user-name.'], function () {
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [SettingController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [SettingController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'password', 'as' => 'login-password.'], function () {
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [SettingController::class, 'update'])->middleware('check.update-password')->name('update');
    });

    Route::group(['prefix' => 'book-sort', 'as' => 'book-sort.'], function () {
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [SettingController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'genre-name', 'as' => 'genre-name.'], function () {
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::post('/store', [SettingController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'search-book', 'as' => 'search-book.'], function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
        Route::get('/create', [MemoGroupController::class, 'create'])->name('create');
        Route::post('/store', [MemoGroupController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'group-user', 'as' => 'group-user.'], function () {
        Route::get('/search', [GroupUserController::class, 'search'])->name('search');
        Route::post('/searchResult', [GroupUserController::class, 'searchResult'])->name('searchResult');
        Route::post('/store', [GroupUserController::class, 'store'])->name('store');
        Route::patch('/update', [GroupUserController::class, 'update'])->name('update');
        Route::delete('/destroy', [GroupUserController::class, 'destroy'])->name('destroy');
        Route::get('/add/{id}', [GroupUserController::class, 'add'])->name('add');
    });

});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['verified'])->name('dashboard');

require __DIR__.'/auth.php';
