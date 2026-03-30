<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
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

    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/send', [PayrollController::class, 'sendBulk'])->name('payroll.sendBulk');
    });
    Route::resource('tickets', TicketController::class)->except(['edit', 'destroy']);
    Route::post('/tickets/{ticket}/comments', [\App\Http\Controllers\TicketCommentController::class, 'store'])->name('ticket.comments.store');
    Route::resource('leave-requests', LeaveRequestController::class)->except(['edit', 'destroy']);
});

require __DIR__.'/auth.php';
