<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Karyawan
Route::resource('employees', EmployeeController::class)->except(['show', 'create']);

// Payroll
Route::get('payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
Route::get('payrolls/{payroll}', [PayrollController::class, 'show'])->name('payrolls.show');
Route::post('payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');
Route::patch('payrolls/{payroll}/finalize', [PayrollController::class, 'finalize'])->name('payrolls.finalize');
Route::delete('payrolls/{payroll}', [PayrollController::class, 'destroy'])->name('payrolls.destroy');

// Slip gaji (download PDF)
Route::get('payrolls/slip/{detail}', [PayrollController::class, 'slip'])->name('payrolls.slip');
