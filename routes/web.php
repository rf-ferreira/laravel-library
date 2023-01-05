<?php

use App\Http\Controllers\WEB\Auth\AuthController;
use App\Http\Controllers\WEB\Book\BookController;
use App\Http\Controllers\WEB\User\UserController;
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

// Authentication
Route::middleware('guest')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

// Book
Route::name('book.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/books', [BookController::class, 'books'])->name('books');

    Route::prefix('/book')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/book/{book}', [BookController::class, 'show'])->name('show');
        });

        Route::middleware('auth')->group(function () {
            Route::post('/store', [BookController::class, 'store'])->name('store');
            Route::put('/{book}/update', [BookController::class, 'update'])->name('update');
            Route::post('/{book}/rent', [BookController::class, 'rent'])->name('rent');
            Route::post('/{book}/return', [BookController::class, 'return'])->name('return');
        });
    });
});

// User
Route::middleware('guest')->prefix('/user')->name('user.')->group(function () {
    Route::get('{user}/profile', [UserController::class, 'profile'])->name('profile');
});