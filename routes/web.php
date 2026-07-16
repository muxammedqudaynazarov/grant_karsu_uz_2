<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HemisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserBookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/hemis', [HemisController::class, 'student'])->name('hemis');
Route::prefix('home')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lang/{locale}', [HomeController::class, 'lang'])->name('lang');
    Route::resource('/tests', TestController::class)->only(['index', 'create', 'store', 'edit', 'update', 'show']);
    //Route::resource('/tests', TestController::class)->only(['index']);
    Route::post('/tests/answer/upload', [TestController::class, 'uploadAnswer'])->name('tests.answer.upload');
    Route::resource('/userbooks', UserBookController::class)->only(['update']);
    Route::get('/certificate/{uuid}/download', [UserBookController::class, 'download'])->name('certificate.download');
    Route::get('/certificate/check/{uuid}', [UserBookController::class, 'check'])->name('certificates.check');
    Route::post('/tests/{test}/finish', [QuizController::class, 'finish'])->name('tests.finish');
    Route::resource('/hemis/enter/questions', QuestionController::class)->only(['create', 'store']);
    Route::resource('/hemis/show/students/results', DepartmentController::class)->only(['index']);
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
