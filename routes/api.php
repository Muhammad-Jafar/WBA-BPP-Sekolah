<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\SchoolClassController;
use App\Http\Controllers\API\v1\SchoolMajorController;
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

        Route::middleware('role:admin')->group(function () {
            Route::get('/administrator/{id}/edit', [AdministratorController::class, 'edit'])->name('administrator.edit');
            Route::get('/school-major/{id}/edit', [SchoolMajorController::class, 'edit'])->name('school-major.edit');
            Route::get('/school-class/{id}/edit', [SchoolClassController::class, 'edit'])->name('school-class.edit');
            Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
            Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');

            Route::get('/cash-transaction/{id}', [CashTransactionController::class, 'show'])->name('cash-transaction.show');
            Route::get('/cash-transaction/{id}/edit', [CashTransactionController::class, 'edit'])->name('cash-transaction.edit');

            Route::get('/billings/{id}', [BillController::class, 'show'])->name('billings.show');

            Route::get('/chart', DashboardChartController::class)->name('chart');
        });

        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('role:student|admin|supervisor');
    });

});
