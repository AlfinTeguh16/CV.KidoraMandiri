<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;

// Public
Route::redirect('/', '/login');

// Authentication
Route::view('/login', 'pages.auth.login')->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::view('/turnover', 'pages.chart-page.turnover')->name('turnover.index');
    Route::view('/insiden', 'pages.chart-page.insiden')->name('insiden.index');
    Route::view('/promosi', 'pages.chart-page.promosi')->name('promosi.index');
    Route::view('/pelatihan', 'pages.chart-page.pelatihan')->name('pelatihan.index');
});

