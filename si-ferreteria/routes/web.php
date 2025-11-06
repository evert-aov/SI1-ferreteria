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
use App\Livewire\DiscountManager;
use Illuminate\Support\Facades\Route;
use App\Livewire\ExitNotes\ExitNoteManager;

Route::middleware(['auth'])->group(function () {
    Route::get('/exit-notes', ExitNoteManager::class)->name('exit-notes');
});

Route::get('/catalog', ProductCatalog::class)->name('catalog.index');
Route::get('/catalog/product/{id}', ProductDetail::class)->name('catalog.product');

Route::view('/login', 'auth.login')->name('login');
Route::redirect('/', 'products')->name('products');

// Rutas de productos (públicas)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Rutas del carrito (públicas - pueden agregar sin login)
Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/agregar/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/actualizar/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/eliminar/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/vaciar', [CartController::class, 'clear'])->name('clear');

    // API para obtener conteo del carrito
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// Rutas de checkout PROTEGIDAS (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Checkout del carrito
    Route::get('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

//    // Procesamiento de órdenes (efectivo/QR)
//    Route::prefix('order')->name('order.')->group(function () {
//        Route::post('/process', [OrderController::class, 'process'])->name('process');
//        Route::get('/success', [OrderController::class, 'success'])->name('success');
//    });

    // Rutas de PayPal
    Route::prefix('paypal')->name('paypal.')->group(function () {
        Route::post('/create', [PayPalController::class, 'createPayment'])->name('create');

        Route::get('/capture', [PayPalController::class, 'capturePayment'])->name('capture');

        Route::get('/success', [PayPalController::class, 'success'])->name('success');

        Route::get('/cancel', [PayPalController::class, 'cancelPayment'])->name('cancel');
    });
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
    Route::get('/discounts', DiscountManager::class)->name('discounts.index');
});

require __DIR__ . '/auth.php';
