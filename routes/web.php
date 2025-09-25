<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\PermissionManagerController;

// ================= AUTH =================
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= DASHBOARD =================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ================= CRUD BARANG =================
Route::middleware('auth')->group(function () {
    // Barang pribadi (atau actingUser utk super)
    Route::resource('barang', BarangController::class);
    // Daftar barang global (read-only)
    Route::get('daftar-barang', [BarangController::class, 'daftar'])->name('barang.daftar');
});

// ================= ACCOUNTS (Super Admin Only) =================
Route::middleware(['auth', 'role:super'])
    ->prefix('admin/accounts')
    ->name('admin.accounts.')
    ->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/', [AccountController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AccountController::class, 'update'])->name('update');
        Route::delete('/{user}', [AccountController::class, 'destroy'])->name('destroy');
    });

// ================= PERMISSIONS (Super & Admin) =================
Route::middleware(['auth', 'role:super,admin'])
    ->prefix('admin/permissions')
    ->name('admin.permissions.')
    ->group(function () {
        Route::get('/', [PermissionManagerController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [PermissionManagerController::class, 'edit'])->name('edit');
        Route::put('/{user}', [PermissionManagerController::class, 'update'])->name('update');
    });
