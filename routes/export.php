<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Export\AdministratorController;
use App\Http\Controllers\Export\StudentController;
use App\Http\Controllers\Export\CashTransactionController;
use App\Http\Controllers\Export\CashTransactionReportController;
use App\Http\Controllers\Export\BillController;

Route::get('/billings/export', BillController::class)->name('billings.export')
->middleware('role:admin');

Route::get('/report/filter/export/{start_date}/{end_date}', CashTransactionReportController::class)
->name('report.export')->middleware('role:admin|supervisor');

Route::get('/students/export', StudentController::class)->name('students.export')
->middleware('role:admin');

Route::get('/cash-transactions/export', CashTransactionController::class)
->name('cash-transactions.export')->middleware('role:admin');

Route::get('/administrators/export', AdministratorController::class)
->name('administrators.export')->middleware('role:admin');
