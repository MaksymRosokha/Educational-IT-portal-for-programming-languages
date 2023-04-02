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

Route::get('/profile/{login}', [\App\Http\Controllers\UserController::class, 'showUserProfile'])->name('profile');

Route::get('/programming_language/{id}', [\App\Http\Controllers\ProgrammingLanguageController::class, 'showOneLanguage']
)
    ->name('programming_language');
Route::get(
    '/programming_language/program/{programID}',
    [\App\Http\Controllers\ProgrammingLanguageController::class, 'showProgram']
)->name('programInProgrammingLanguage');

Route::get('/lesson/{lessonID}', [\App\Http\Controllers\LessonController::class, 'showLesson'])->name('lesson');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'loginUser'])
        ->name('loginProcess');

    Route::get('/signup', [\App\Http\Controllers\AuthController::class, 'showSignUpForm'])
        ->name('signUp');
    Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'registerUser'])
        ->name('registerProcess');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logoutUser'])
        ->name('logout');
    Route::post('/profile/change_password', [\App\Http\Controllers\UserController::class, 'changeUserPassword'])
        ->name('changePassword');

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\UserController::class, 'showAdminPanel'])->name('admin');
        Route::get('/admin/delete_user/{id}', [\App\Http\Controllers\UserController::class, 'deleteUser'])->name(
            'deleteUser'
        );
    });
});