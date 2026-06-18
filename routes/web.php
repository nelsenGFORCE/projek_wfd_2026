<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminStudioController;
use App\Http\Controllers\Admin\AdminTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [HomeController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::middleware('auth')->group(function () {
    Route::get('/booking/{schedule}/seats', [BookingController::class, 'selectSeats'])->name('booking.seats');
    Route::post('/booking/{schedule}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::get('/booking/{transaction}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{transaction}/confirm', [BookingController::class, 'confirmPayment'])->name('booking.confirm');
    Route::get('/my-tickets', [TransactionHistoryController::class, 'index'])->name('transactions.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies', AdminMovieController::class);
    Route::resource('studios', AdminStudioController::class);
    Route::resource('schedules', AdminScheduleController::class);
    Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
});

require __DIR__.'/auth.php';
