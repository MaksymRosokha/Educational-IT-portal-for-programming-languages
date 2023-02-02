<?php

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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('main');
Route::get('/programming_languages', [\App\Http\Controllers\ProgrammingLanguageController::class, 'showPage'])
    ->name('programming_languages');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login/process', [\App\Http\Controllers\AuthController::class, 'loginUser'])
        ->name('login_process');

    Route::get('/signup', [\App\Http\Controllers\AuthController::class, 'showSignUpForm'])
        ->name('signUp');
    Route::post('/signup/process', [\App\Http\Controllers\AuthController::class, 'registerUser'])
        ->name('registerUser');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logoutUser'])
        ->name('logout');
});