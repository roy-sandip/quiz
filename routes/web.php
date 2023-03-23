<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::as('public.')->group(function(){
    Route::get('/quiz', [QuizController::class, 'quiz'])->name('questions.random');
    Route::post('/question/check', [QuizController::class, 'checkAnswer'])->name('questions.check-answer');
});


Route::prefix('admin')->as('admin.')->middleware('auth')->group(function(){
    Route::resource('/questions', QuestionController::class);

    Route::get('/import', [QuestionController::class, 'import']);
});