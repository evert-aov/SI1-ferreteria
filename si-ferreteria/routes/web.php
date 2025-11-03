<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Catalog\ProductCatalog;
use App\Livewire\Catalog\ProductDetail;
use App\Livewire\Inventory\CategoryManager;
use App\Livewire\Inventory\ProductManager;
use App\Livewire\Purchase\PurchaseManager;
use App\Livewire\Purchase\SupplierManager;
use App\Livewire\ReportAndAnalysis\AuditLog;
use App\Livewire\ReportAndAnalysis\ProductAlertManager;
use App\Livewire\Sales\SaleManager;
use App\Livewire\UserSecurity\PermissionManager;
use App\Livewire\UserSecurity\RoleManager;
use App\Livewire\UserSecurity\UserManager;
use Illuminate\Support\Facades\Route;

Route::get('/catalog', ProductCatalog::class)->name('catalog.index');
Route::get('/catalog/product/{id}', ProductDetail::class)->name('catalog.product');

Route::view('/login', 'auth.login')->name('login');
Route::redirect('/', 'products')->name('products');

// Rutas de productos (públicas)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Rutas del carrito (públicas - pueden agregar sin login)
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/actualizar/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');

// API para obtener conteo del carrito
Route::get('/api/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

// Rutas de checkout PROTEGIDAS (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/carrito/procesar', [CartController::class, 'processOrder'])->name('cart.process');
    Route::get('/carrito/exito', [CartController::class, 'success'])->name('cart.success');

    // Rutas de PayPal (también protegidas)
    Route::post('/paypal/create', [PayPalController::class, 'createPayment'])->name('paypal.create');
    Route::get('/paypal/success', [PayPalController::class, 'capturePayment'])->name('paypal.success');
    Route::get('/paypal/cancel', [PayPalController::class, 'cancelPayment'])->name('paypal.cancel');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/product-alerts', ProductAlertManager::class)->name('product-alerts.index');
    Route::get('/users', UserManager::class)->name('users.index');
    Route::get('/roles', RoleManager::class)->name('roles.index');
    Route::get('/audit-logs', AuditLog::class)->name('audit-logs.index');
    Route::get('/permissions', PermissionManager::class)->name('permissions.index');
    Route::get('/product-inventory', ProductManager::class)->name('product-inventory.index');
    Route::get('/categories', CategoryManager::class)->name('categories.index');
    Route::get('/purchase', PurchaseManager::class)->name('purchase.index');
    Route::get('/suppliers', SupplierManager::class)->name('suppliers.index');
    Route::get('/sales', SaleManager::class)->name('sales.index');
});

require __DIR__ . '/auth.php';
