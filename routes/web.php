<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\CashTransactionFilterController;
use App\Http\Controllers\CashTransactionReportController;
use App\Http\Controllers\StudentHistoryController;
use App\Http\Controllers\BillController;

require __DIR__ . '/auth.php';

// If accessing root path "/" it will be redirect to /login
Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('role:admin|supervisor');

    Route::resource('students', StudentController::class)->except('create', 'show', 'edit')->middleware('role:admin');

    // Route::resource('administrators', AdministratorController::class)->except('create', 'show', 'edit', 'destroy')
    // ->middleware('role:admin|supervisor');

    // Route::get('/cash-transactions/filter', CashTransactionFilterController::class)->name('cash-transactions.filter')
    // ->middleware('role:admin|supervisor');

    Route::resource('cash-transactions', CashTransactionController::class)->except('create', 'show', 'edit')
    ->middleware('role:admin|supervisor');

    Route::resource('billings', BillController::class)->except('create', 'show')->middleware('role:admin|supervisor');

    Route::get('/report', CashTransactionReportController::class)->name('report.index')->middleware('role:admin|supervisor');

    // Soft Deletes Routes
    Route::controller(StudentHistoryController::class)->prefix('/students/history')->name('students.')->group(function () {
        Route::get('', 'index')->name('index.history');
        Route::post('{id}', 'restore')->name('restore.history');
        Route::delete('{id}', 'destroy')->name('destroy.history');
    })->middleware('role:admin');

    require __DIR__ . '/export.php';
});
