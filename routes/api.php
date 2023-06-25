<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AdministratorController;
use App\Http\Controllers\API\v1\CashTransactionController;
use App\Http\Controllers\API\v1\DashboardChartController;
use App\Http\Controllers\API\v1\LoginController;
use App\Http\Controllers\API\v1\LogoutController;
use App\Http\Controllers\API\v1\StudentController;
use App\Http\Controllers\API\v1\BillController;

Route::name('api.')->prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, 'loginAdmin'])->name('login');
    Route::post('/login/student', [LoginController::class, 'loginStudent'])->name('login.student');

    Route::middleware('jwt')->group(function () {
        // Route::get('/student/{id}', [StudentController::class, 'show'])
        // ->name('student.show')->middleware('role:admin');

        Route::get('/student/{id}/edit', [StudentController::class, 'edit'])
        ->name('student.edit')->middleware('role:admin');

        // Route::get('/cash-transaction/{id}', [CashTransactionController::class, 'show'])
        // ->name('cash-transaction.show')->middleware('role:admin');

        Route::get('/billings/{id}', [BillController::class, 'show'])
        ->name('billings.show');
        // ->middleware('role:student');

        Route::post('/transaction/pay', [CashTransactionController::class, 'pay'])
        ->name('cash-transaction.pay');
        // ->middleware('role:student'); // make request for midtrans

        Route::post('/transaction/status', [CashTransactionController::class, 'status'])
        ->name('cash-transaction.status');

        // Route::get('/chart', DashboardChartController::class)->name('chart')->middleware('role:admin');

        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('role:student|admin|supervisor');
    });

    Route::post('/transaction/notif', [CashTransactionController::class, 'handleNotification'])
    ->name('cash-transaction.status');
    // ->middleware('role:admin|student'); // Check status of transaction

});
