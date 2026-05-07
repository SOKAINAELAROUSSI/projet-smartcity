<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianController;

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    return view('welcome', compact('categories'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reports', ReportController::class);
    
    // Custom Admin routes
    Route::post('/reports/{report}/assign', [AdminController::class, 'assign'])->name('admin.assign');
    Route::resource('categories', CategoryController::class);
    
    // Custom Technician routes
    Route::post('/reports/{report}/update', [TechnicianController::class, 'update'])->name('technician.update');
    Route::post('/reports/{report}/accept', [TechnicianController::class, 'accept'])->name('technician.accept');
    
    // Rating
    Route::post('/reports/{report}/rate', [ReportController::class, 'rate'])->name('reports.rate');
});




