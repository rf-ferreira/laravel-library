<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Book\BookController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::middleware('guest')->name('api.auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

// Book
Route::name('api.book.')->group(function () {
    Route::get('/books', [BookController::class, 'books'])->name('books');

    Route::prefix('/book')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/book/{book}', [BookController::class, 'show'])->name('show');
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/store', [BookController::class, 'store'])->name('store');
            Route::put('/{book}/update', [BookController::class, 'update'])->name('update');
            Route::post('/{book}/rent', [BookController::class, 'rent'])->name('rent');
            Route::post('/{book}/return', [BookController::class, 'return'])->name('return');
        });
    });
});

// User
Route::middleware('guest')->prefix('/user')->name('api.user.')->group(function () {
    Route::get('{user}/profile', [UserController::class, 'profile'])->name('profile');
});