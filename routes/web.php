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

Route::get('/user/{login}', [\App\Http\Controllers\UserController::class, 'showUserProfile'])->name('user');

Route::get('/programming_language/{id}', [\App\Http\Controllers\ProgrammingLanguageController::class, 'showOneLanguage']
)->name('programming_language');
Route::get(
    '/programming_language/program/{programID}',
    [\App\Http\Controllers\ProgramInProgrammingLanguageController::class, 'showProgram']
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

    Route::post('/user/change_password', [\App\Http\Controllers\UserController::class, 'changeUserPassword'])
        ->name('changePassword');
    Route::post('/user/edit_profile', [\App\Http\Controllers\UserController::class, 'editProfile'])
        ->name('editProfile');
    Route::post('/delete_user', [\App\Http\Controllers\UserController::class, 'deleteUser'])
        ->name('deleteUser');

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'showAdminPanel'])->name('admin');
        Route::post('/change_role', [\App\Http\Controllers\AdminController::class, 'changeRole'])->name('changeRole');

        Route::post(
            '/create_programming_language',
            [\App\Http\Controllers\ProgrammingLanguageController::class, 'create']
        )->name('createProgrammingLanguage');
        Route::post(
            '/update_programming_language',
            [\App\Http\Controllers\ProgrammingLanguageController::class, 'update']
        )->name('updateProgrammingLanguage');
        Route::post(
            '/delete_programming_language',
            [\App\Http\Controllers\ProgrammingLanguageController::class, 'delete']
        )->name('deleteProgrammingLanguage');

        Route::post(
            '/create_program_in_programming_language',
            [\App\Http\Controllers\ProgramInProgrammingLanguageController::class, 'create']
        )->name('createProgramInProgrammingLanguage');
        Route::post(
            '/update_program_in_programming_language',
            [\App\Http\Controllers\ProgramInProgrammingLanguageController::class, 'update']
        )->name('updateProgramInProgrammingLanguage');
        Route::post(
            '/delete_program_in_programming_language',
            [\App\Http\Controllers\ProgramInProgrammingLanguageController::class, 'delete']
        )->name('deleteProgramInProgrammingLanguage');

        Route::post('/create_lesson', [\App\Http\Controllers\LessonController::class, 'create'])
            ->name('createLesson');
        Route::post('/update_lesson', [\App\Http\Controllers\LessonController::class, 'update'])
            ->name('updateLesson');
        Route::post('/delete_lesson', [\App\Http\Controllers\LessonController::class, 'delete'])
            ->name('deleteLesson');
    });
});