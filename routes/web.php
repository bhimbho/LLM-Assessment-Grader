<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [AccountController::class, 'updatePassword'])->name('change-password.update');
    });
    
    Route::prefix('user-management')->name('user-management.')->middleware('admin')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/ban', [UserManagementController::class, 'ban'])->name('ban');
        Route::post('/{user}/unban', [UserManagementController::class, 'unban'])->name('unban');
    });
    
    Route::prefix('student-management')->name('student-management.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [StudentController::class, 'export'])->name('export');
        Route::get('/export/excel', [StudentController::class, 'export'])->name('export.excel');
        Route::get('/export/students', [StudentController::class, 'exportStudents'])->name('export.students');
        Route::get('/export/assessments', [StudentController::class, 'exportToCsv'])->name('export.assessments');
    });
    
    Route::prefix('question-bank')->name('question-bank.')->group(function () {
        Route::get('/', [QuestionBankController::class, 'index'])->name('index');
        Route::get('/create', [QuestionBankController::class, 'create'])->name('create');
        Route::post('/', [QuestionBankController::class, 'store'])->name('store');
        Route::get('/{question}', [QuestionBankController::class, 'show'])->name('show');
        Route::get('/{question}/edit', [QuestionBankController::class, 'edit'])->name('edit');
        Route::put('/{question}', [QuestionBankController::class, 'update'])->name('update');
        Route::delete('/{question}', [QuestionBankController::class, 'destroy'])->name('destroy');
    });
    
    Route::get('/assessment/upload/{question}', [AssessmentController::class, 'upload'])->name('assessment.upload');
    Route::get('/assessment/{question}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::get('/assessment/{question}/create', [AssessmentController::class, 'create'])->name('assessment.create');
    Route::get('/assessment/{question}/export', [AssessmentController::class, 'export'])->name('assessment.export');
    Route::get('/assessment/{question}/export/csv', [AssessmentController::class, 'exportToCsv'])->name('assessment.export.csv');
    Route::get('/assessment/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessment.edit');
    Route::put('/assessment/{assessment}', [AssessmentController::class, 'update'])->name('assessment.update');
    Route::delete('/assessment/{assessment}', [AssessmentController::class, 'destroy'])->name('assessment.destroy');
    Route::post('/assessment/{question}', [AssessmentController::class, 'store'])->name('assessment.store');
});
