<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/now-showing', [MovieController::class, 'nowShowing']);
Route::get('/movies/coming-soon', [MovieController::class, 'comingSoon']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/schedules/{id}/seats', [ScheduleController::class, 'seats']);