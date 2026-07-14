<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserBookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::prefix('home')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lang/{locale}', [HomeController::class, 'lang'])->name('lang');
    Route::resource('/tests', TestController::class);
    Route::post('/tests/answer/upload', [TestController::class, 'uploadAnswer'])->name('tests.answer.upload');
    Route::resource('/userbooks', UserBookController::class)->only(['update']);
    Route::get('/certificate/{uuid}/download', [UserBookController::class, 'download'])->name('certificate.download');
    Route::get('/certificate/check/{uuid}', [UserBookController::class, 'download'])->name('certificates.check');
    Route::resource('/questions', QuestionController::class);
});
