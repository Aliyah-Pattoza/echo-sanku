<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('nasabah.dashboard');
    })->name('dashboard');
});

// Nasabah Routes
Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Nasabah\DashboardController::class, 'index'])->name('dashboard');
    
    // Exchange History
    Route::get('/exchange-history', [App\Http\Controllers\Nasabah\ExchangeHistoryController::class, 'index'])->name('exchange-history.index');
    Route::get('/exchange-history/{id}', [App\Http\Controllers\Nasabah\ExchangeHistoryController::class, 'show'])->name('exchange-history.show');
    
    // Withdrawal
    Route::get('/withdrawal', [App\Http\Controllers\Nasabah\WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal/create', [App\Http\Controllers\Nasabah\WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [App\Http\Controllers\Nasabah\WithdrawalController::class, 'store'])->name('withdrawal.store');
    Route::get('/withdrawal/{id}', [App\Http\Controllers\Nasabah\WithdrawalController::class, 'show'])->name('withdrawal.show');

    // Profile
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile photo routes
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Exchange Management
    Route::resource('exchange', App\Http\Controllers\Admin\ExchangeController::class);

    // Transaction (Withdrawal) Management
    Route::get('/transaction', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/transaction/{id}/approve', [App\Http\Controllers\Admin\TransactionController::class, 'approve'])->name('transaction.approve');
    Route::post('/transaction/{id}/complete', [App\Http\Controllers\Admin\TransactionController::class, 'complete'])->name('transaction.complete');
    Route::post('/transaction/{id}/reject', [App\Http\Controllers\Admin\TransactionController::class, 'reject'])->name('transaction.reject');

    // Reports
    Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('report.export');

    // Waste Type Management
    Route::resource('waste-type', App\Http\Controllers\Admin\WasteTypeController::class);
});