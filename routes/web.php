<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kasir\MemberController;
use App\Http\Controllers\Kasir\PenjualanOfflineController;
use App\Http\Controllers\Member\ProductController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware([RoleMiddleware::class . ':admin'])->group(function() {
    Route::get('/admin-dashboard', [AdminDashboard::class, 'index'])->name('admin.index');
    Route::prefix('admin')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::resource('kategoris', KategoriController::class);
        Route::resource('barangs', BarangController::class);
        Route::resource('pembelians', PembelianController::class);
    });
});

Route::middleware([RoleMiddleware::class . ':kasir'])->group(function() {
    Route::prefix('cashier')->group(function () {
        Route::get('/', function() {
            return view('cashier.index');
        })->name('cashier.index');
        Route::resource('members', MemberController::class);
        Route::resource('penjualan-offline', PenjualanOfflineController::class);
    });
});

Route::middleware([RoleMiddleware::class . ':member'])->group(function() {

    Route::get('/produk', [ProductController::class, 'index'])->name('member.index');

});