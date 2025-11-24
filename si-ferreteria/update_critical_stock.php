<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Inventory\Product;

echo "=== ACTUALIZANDO PRODUCTOS A STOCK CRÍTICO ===\n\n";

// Desactivar observers para evitar problemas con auditoría
Product::unsetEventDispatcher();

// Obtener 8 productos aleatorios activos
$products = Product::where('is_active', true)
    ->inRandomOrder()
    ->limit(8)
    ->get();

$updatedCount = 0;

foreach ($products as $index => $product) {
    // Los primeros 3 sin stock, el resto bajo stock
    $newStock = $index < 3 ? 0 : rand(1, 8);

    $product->update(['stock' => $newStock]);

    $status = $newStock === 0 ? '🔴 SIN STOCK' : '🟠 BAJO STOCK';
    echo "{$status} - {$product->name}\n";
    echo "   Stock anterior: {$product->getOriginal('stock')} → Nuevo stock: {$newStock} unidades\n\n";

    $updatedCount++;
}

echo "✅ {$updatedCount} productos actualizados con stock crítico\n";
echo "\n🎯 Recarga el dashboard en http://localhost:8000/dashboard para ver los cambios\n";
