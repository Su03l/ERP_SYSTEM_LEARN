<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('supervisor')->group(function () {
        Route::resource('employees', EmployeeController::class)->except(['destroy']);
        // تقييم الأداء
        Route::get('/performance', [PerformanceController::class, 'index'])->name('performance.index');
        Route::get('/performance/search', [PerformanceController::class, 'searchEmployee'])->name('performance.search');
        Route::post('/performance', [PerformanceController::class, 'store'])->name('performance.store');
        Route::get('/performance/{performance}', [PerformanceController::class, 'show'])->name('performance.show');
        Route::get('/performance/{performance}/edit', [PerformanceController::class, 'edit'])->name('performance.edit');
        Route::put('/performance/{performance}', [PerformanceController::class, 'update'])->name('performance.update');
        Route::get('/performance/{performance}/pdf', [PerformanceController::class, 'exportPdf'])->name('performance.pdf');
    });

    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/send', [PayrollController::class, 'sendBulk'])->name('payroll.sendBulk');
    });

    Route::resource('tickets', TicketController::class)->except(['edit', 'destroy']);
    Route::post('/tickets/{ticket}/comments', [\App\Http\Controllers\TicketCommentController::class, 'store'])->name('ticket.comments.store');
    Route::resource('leave-requests', LeaveRequestController::class)->except(['edit', 'destroy']);
});

require __DIR__.'/auth.php';
