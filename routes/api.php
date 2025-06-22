<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('chart')->group(function () {
    Route::get('/turnover', [ChartController::class, 'turnover']);
    Route::get('/insiden', [ChartController::class, 'insiden']);
    Route::get('/pelatihan', [ChartController::class, 'pelatihan']);
    Route::get('/promosi', [ChartController::class, 'promosi']);
});
