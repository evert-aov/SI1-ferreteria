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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;

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
    
    // Reportes dinámicos
    Route::get('/reports/dynamic', [ReportController::class, 'index'])->name('reports.users.index');
    Route::post('/reports/get-table-fields', [ReportController::class, 'getTableFields'])->name('reports.get-table-fields');
    Route::post('/reports/dynamic/generate', [ReportController::class, 'generate'])->name('reports.users.generate');
    Route::post('/reports/download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');
    Route::post('/reports/download-excel', [ReportController::class, 'downloadExcel'])->name('reports.download-excel');
    Route::post('/reports/download-html', [ReportController::class, 'downloadHtml'])->name('reports.download-html');
    
    // Review routes
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/helpful', [ReviewController::class, 'markHelpful'])->name('reviews.helpful');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Admin routes
    Route::get('/admin/reviews', [ReviewController::class, 'moderate'])->name('admin.reviews.moderate');
});

require __DIR__ . '/auth.php';
