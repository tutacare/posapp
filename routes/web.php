<?php

use App\Livewire\CategoryManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/sales-data', [DashboardController::class, 'salesData'])->name('dashboard.sales-data');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/category-management', CategoryManagement::class)->name('category.management');
        Route::resource('products', ProductController::class);
        Route::get('/reports/profit-loss', [App\Http\Controllers\ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        // Route::get('/dashboard/sales-data', [App\Http\Controllers\DashboardController::class, 'salesData'])->name('dashboard.sales-data');
    });

    Route::middleware(['role:Cashier|Admin'])->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::get('/pos/products', [PosController::class, 'getProducts'])->name('pos.products');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
        Route::get('/order/completed/{order}', [OrderController::class, 'showCompleted'])->name('order.completed');
    });
});

require __DIR__ . '/auth.php';
