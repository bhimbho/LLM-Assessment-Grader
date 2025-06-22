<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionBankController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/question-bank', QuestionBankController::class);
    Route::get('/question-bank/upload/{question}', [QuestionBankController::class, 'upload'])->name('question-bank.upload');
    Route::get('/assessment/upload/{question}', [AssessmentController::class, 'upload'])->name('assessment.upload');
    Route::get('/assessment/{question}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::get('/assessment/{question}/create', [AssessmentController::class, 'create'])->name('assessment.create');
    Route::delete('/assessment/{assessment}', [AssessmentController::class, 'destroy'])->name('assessment.destroy');
    Route::post('/assessment/{question}', [AssessmentController::class, 'store'])->name('assessment.store');
    // Route::resource('/assessment', AssessmentController::class);
});
