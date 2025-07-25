<?php

use App\Livewire\PosPage;
use App\Livewire\CategoryManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/category-management', CategoryManagement::class)->name('category.management');
        Route::resource('products', ProductController::class);
    });

    Route::middleware(['role:Cashier|Admin'])->group(function () {
        Route::get('/pos', PosPage::class)->name('pos.index');
        Route::get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
    });
});

require __DIR__ . '/auth.php';
