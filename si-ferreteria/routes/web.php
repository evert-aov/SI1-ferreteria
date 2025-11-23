<?php

use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\PayPalController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reports\ReportController;
use App\Livewire\Admin\Security\PermissionManager;
use App\Livewire\Admin\Security\RoleManager;
use App\Livewire\Admin\Security\UserManager;
use App\Livewire\Commerce\DiscountManager;
use App\Livewire\Commerce\PurchaseManager;
use App\Livewire\Commerce\SaleManager;
use App\Livewire\Commerce\SupplierManager;
use App\Livewire\Ecommerce\ProductCatalog;
use App\Livewire\Ecommerce\ProductDetail;
use App\Livewire\Inventory\CategoryManager;
use App\Livewire\Inventory\ExitNoteManager;
use App\Livewire\Inventory\ProductAlertManager;
use App\Livewire\Inventory\ProductManager;
use App\Livewire\Reports\AuditLog;
use Illuminate\Support\Facades\Route;

// ========== RUTAS PÚBLICAS ==========

Route::view('/login', 'auth.login')->name('login');
Route::redirect('/', 'products')->name('products');

// Catálogo y tienda (públicas)
Route::get('/catalog', ProductCatalog::class)->name('catalog.index');
Route::get('/catalog/product/{id}', ProductDetail::class)->name('catalog.product');

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
    
    // Rutas de cupones de descuento
    Route::post('/aplicar-descuento', [CartController::class, 'applyDiscount'])->name('apply-discount');
    Route::post('/remover-descuento', [CartController::class, 'removeDiscount'])->name('remove-discount');

    // API para obtener conteo del carrito
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// ========== RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN) ==========

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== GESTIÓN DE USUARIOS Y SEGURIDAD ==========
    Route::get('/users', UserManager::class)->name('users.index');
    Route::get('/roles', RoleManager::class)->name('roles.index');
    Route::get('/permissions', PermissionManager::class)->name('permissions.index');
    
    // ========== GESTIÓN DE INVENTARIO ==========
    Route::get('/product-inventory', ProductManager::class)->name('product-inventory.index');
    Route::get('/categories', CategoryManager::class)->name('categories.index');
    Route::get('/product-alerts', ProductAlertManager::class)->name('product-alerts.index');
    Route::get('/exit-notes', ExitNoteManager::class)->name('exit-notes');
    
    // ========== OPERACIONES COMERCIALES ==========
    Route::get('/purchase', PurchaseManager::class)->name('purchase.index');
    Route::get('/suppliers', SupplierManager::class)->name('suppliers.index');
    Route::get('/sales', SaleManager::class)->name('sales.index');
    Route::get('/discounts', DiscountManager::class)->name('discounts.index');
    
    // ========== PLATAFORMA E-COMMERCE ==========
    
    // Checkout del carrito
    Route::get('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // Rutas de PayPal
    Route::prefix('paypal')->name('paypal.')->group(function () {
        Route::post('/create', [PayPalController::class, 'createPayment'])->name('create');
        Route::get('/capture', [PayPalController::class, 'capturePayment'])->name('capture');
        Route::get('/success', [PayPalController::class, 'success'])->name('success');
        Route::get('/cancel', [PayPalController::class, 'cancelPayment'])->name('cancel');
    });
    
    // Review routes
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/helpful', [ReviewController::class, 'markHelpful'])->name('reviews.helpful');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Admin routes
    Route::get('/admin/reviews', [ReviewController::class, 'moderate'])->name('admin.reviews.moderate');
    
    // ========== DELIVERY MANAGEMENT ==========
    // Delivery routes (for delivery personnel)
    Route::prefix('deliveries')->name('deliveries.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Deliveries\DeliveryController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Deliveries\DeliveryController::class, 'show'])->name('show');
        Route::post('/{id}/mark-delivered', [\App\Http\Controllers\Deliveries\DeliveryController::class, 'markAsDelivered'])->name('mark-delivered');
    });

    // Customer order routes
    Route::prefix('my-orders')->name('customer.orders.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Customer\CustomerOrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [\App\Http\Controllers\Customer\CustomerOrderController::class, 'cancel'])->name('cancel');
    });
    
    // ========== REPORTES Y ANÁLISIS ==========
    Route::get('/audit-logs', AuditLog::class)->name('audit-logs.index');
    
    // Reportes dinámicos
    Route::get('/reports/dynamic', [ReportController::class, 'index'])->name('reports.users.index');
    Route::post('/reports/get-table-fields', [ReportController::class, 'getTableFields'])->name('reports.get-table-fields');
    Route::get('/reports/dynamic/generate', [ReportController::class, 'generate'])->name('reports.users.generate');
    Route::post('/reports/download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');
    Route::post('/reports/download-excel', [ReportController::class, 'downloadExcel'])->name('reports.download-excel');
    Route::post('/reports/download-html', [ReportController::class, 'downloadHtml'])->name('reports.download-html');
});

require __DIR__ . '/auth.php';
