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
Route::middleware('not_blocked_user')->group(function () {
    Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('main');

    Route::get('/user/{login}', [\App\Http\Controllers\UserController::class, 'showUserProfile'])->name('user');

    Route::get(
        '/programming_language/{id}',
        [\App\Http\Controllers\ProgrammingLanguageController::class, 'showOneLanguage']
    )->name('programming_language');
    Route::get(
        '/programming_language/program/{programID}',
        [\App\Http\Controllers\ProgramInProgrammingLanguageController::class, 'showProgram']
    )->name('programInProgrammingLanguage');
    Route::get('/lesson/{lessonID}', [\App\Http\Controllers\LessonController::class, 'showLesson'])->name('lesson');


    Route::get('/questions', [\App\Http\Controllers\QuestionController::class, 'showPage'])
        ->name('questions');
    Route::post('/search_questions', [\App\Http\Controllers\QuestionController::class, 'search'])
        ->name('searchQuestions');
    Route::post('/load_more_questions', [\App\Http\Controllers\QuestionController::class, 'showMoreQuestions'])
        ->name('loadMoreQuestions');

    Route::get('/answers/{questionID}', [\App\Http\Controllers\AnswerController::class, 'showPage'])
        ->name('answers');
    Route::post('/search_answers', [\App\Http\Controllers\AnswerController::class, 'search'])
        ->name('searchAnswers');
    Route::post('/load_more_answers', [\App\Http\Controllers\AnswerController::class, 'showMoreAnswers'])
        ->name('loadMoreAnswers');
});

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
    Route::get('/is_blocked', [\App\Http\Controllers\UserController::class, 'showBlockedUserPage'])
        ->name('blockedUser');

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logoutUser'])
        ->name('logout');

    Route::middleware('not_blocked_user')->group(function () {
        Route::post('/user/change_password', [\App\Http\Controllers\UserController::class, 'changeUserPassword'])
            ->name('changePassword');
        Route::post('/user/edit_profile', [\App\Http\Controllers\UserController::class, 'editProfile'])
            ->name('editProfile');
        Route::post('/delete_user', [\App\Http\Controllers\UserController::class, 'deleteUser'])
            ->name('deleteUser');

        Route::post('/calculate_test', [\App\Http\Controllers\TestController::class, 'calculateTest'])
            ->name('calculateTest');


        Route::post('/question_create', [\App\Http\Controllers\QuestionController::class, 'create'])
            ->name('createQuestion');
        Route::post('/question_update', [\App\Http\Controllers\QuestionController::class, 'update'])
            ->name('updateQuestion');
        Route::post('/question_delete', [\App\Http\Controllers\QuestionController::class, 'delete'])
            ->name('deleteQuestion');
        Route::post('/only_my_questions', [\App\Http\Controllers\QuestionController::class, 'showOnlyMyQuestions'])
            ->name('showOnlyMyQuestions');

        Route::post('/answer_create', [\App\Http\Controllers\AnswerController::class, 'create'])
            ->name('createAnswer');
        Route::post('/answer_update', [\App\Http\Controllers\AnswerController::class, 'update'])
            ->name('updateAnswer');
        Route::post('/answer_delete', [\App\Http\Controllers\AnswerController::class, 'delete'])
            ->name('deleteAnswer');
        Route::post('/only_my_answers', [\App\Http\Controllers\AnswerController::class, 'showOnlyMyAnswers'])
            ->name('showOnlyMyAnswers');
        Route::post('/get_answer_by_id', [\App\Http\Controllers\AnswerController::class, 'getAnswerByID'])
            ->name('getAnswerByID');


        Route::middleware('admin')->prefix('admin')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminController::class, 'showAdminPanel'])->name('admin');
            Route::post('/search', [\App\Http\Controllers\AdminController::class, 'search'])->name('search');
            Route::post('/load_more_users', [\App\Http\Controllers\AdminController::class, 'loadMoreUsers'])->name('loadMoreUsers');

            Route::post('/change_role', [\App\Http\Controllers\AdminController::class, 'changeRole'])->name(
                'changeRole'
            );
            Route::post('/block_user', [\App\Http\Controllers\AdminController::class, 'blockUser'])->name('blockUser');
            Route::post('/unlock_user', [\App\Http\Controllers\AdminController::class, 'unlockUser'])->name(
                'unlockUser'
            );

            Route::post('/create_test', [\App\Http\Controllers\TestController::class, 'createTest'])
                ->name('createTest');
            Route::post('/update_test', [\App\Http\Controllers\TestController::class, 'updateTest'])
                ->name('updateTest');
            Route::post('/delete_test', [\App\Http\Controllers\TestController::class, 'deleteTest'])
                ->name('deleteTest');

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

            Route::post('/upload_content_image', [\App\Http\Controllers\ImageController::class, 'uploadContentImage'])
                ->name('uploadContentImage');
        });
    });
});