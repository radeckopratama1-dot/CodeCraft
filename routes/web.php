<?php

use App\Http\Controllers\LabController;
use Illuminate\Support\Facades\Route;

// Main landing page with MySQL data
Route::get('/', [LabController::class, 'index'])->name('home');

// Async endpoint for completing interactive labs & real-time XP sync
Route::post('/lab/complete', [LabController::class, 'completeModule'])->name('lab.complete');
