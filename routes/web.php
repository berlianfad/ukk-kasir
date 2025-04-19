<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user');

    Route::resource('/products', ProductController::class)->except(['index']);
    Route::put('/products/{id}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
    Route::resource('/users', UserController::class)->except(['index']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});


Route::middleware(['role:Employee'])->group(function () {
    Route::get('/dashboard/employee', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

    Route::resource('/orders', OrderController::class)->except(['index']);

    Route::match(['get', 'post'], '/summary/member', [OrderController::class, 'member'])->name('order.member');
    Route::match(['get', 'post'], '/summary/pembayaran', [OrderController::class, 'pembayaran'])->name('order.pembayaran');
    Route::match(['get', 'post'], '/detail-pembayaran', [OrderController::class, 'detailPembayaran'])->name('order.detail-pembayaran');
    Route::match(['get', 'post'], '/order/summary', [OrderController::class, 'summary'])->name('order.summary');
    Route::post('/order/submit', [OrderController::class, 'submit'])->name('order.submit');
});

Route::middleware(['role:Admin,Employee'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders-export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/{id}/download-pdf', [OrderController::class, 'downloadPDF'])->name('orders.downloadPDF');
});
