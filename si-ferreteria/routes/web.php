<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Inventory\CategoryManager;
use App\Livewire\Inventory\ProductManager;
use App\Livewire\Purchase\PurchaseManager;
use App\Livewire\Purchase\SupplierManager;
use App\Livewire\ReportAndAnalysis\AuditLog;
use App\Livewire\ReportAndAnalysis\ProductAlertManager;
use App\Livewire\UserSecurity\PermissionManager;
use App\Livewire\UserSecurity\RoleManager;
use App\Livewire\UserSecurity\UserManager;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/product-alerts', ProductAlertManager::class)->name('product-alerts.index');
    //Route::middleware('Administrador')->group(function () {
        Route::get('/users', UserManager::class)->name('users.index');
        Route::get('/roles', RoleManager::class)->name('roles.index');
        Route::get('/audit-logs', AuditLog::class)->name('audit-logs.index');
        Route::get('/permissions', PermissionManager::class)->name('permissions.index');
        Route::get('/product-inventory', ProductManager::class)->name('product-inventory.index');
        Route::get('/categories', CategoryManager::class)->name('categories.index');
        Route::get('/purchase', PurchaseManager::class)->name('purchase.index');

        //gestión de proveedores
        Route::get('/suppliers', SupplierManager::class)->name('suppliers.index');
    //});
});

require __DIR__ . '/auth.php';
