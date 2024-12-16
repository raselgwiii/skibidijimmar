<?php

use App\Http\Controllers\EducationalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Redirect root to login if not authenticated
Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Auth routes (public)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Order routes
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order:order_id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order:order_id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order:order_id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order:order_id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::delete('order-items/{orderItem:order_item_id}', [OrderController::class, 'destroyItem'])->name('order-items.destroy');

    // Product routes
    Route::resource('products', ProductController::class);

    // Customer routes
    Route::resource('customers', CustomerController::class);
});