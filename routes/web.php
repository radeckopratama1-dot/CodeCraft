<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LabController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [LabController::class, 'index'])->name('home');

// Guest Authentication Routes (Middleware: guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/login/demo', [AuthController::class, 'demoLogin'])->name('login.demo');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Protected Student Routes (Middleware: auth)
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Classes & Lab routes protected by auth
    Route::get('/classes', [LabController::class, 'classes'])->name('classes');
    Route::get('/lab', [LabController::class, 'lab'])->name('lab');
    
    // Asynchronous XP sync endpoint
    Route::post('/lab/complete', [LabController::class, 'completeModule'])->name('lab.complete');
});
