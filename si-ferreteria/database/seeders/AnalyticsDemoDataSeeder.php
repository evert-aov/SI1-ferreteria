<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Payment;
use App\Models\Purchase\Entry;
use App\Models\Purchase\EntryDetail;
use App\Models\Inventory\Product;
use App\Models\Review;
use App\Models\User_security\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnalyticsDemoDataSeeder extends Seeder
{
    /**
     * Genera datos de prueba para el Dashboard Analítico
     * Incluye: Ventas, Compras, Reviews de los últimos 12 meses
     */
    public function run(): void
    {
        $this->command->info('🚀 Generando datos de demostración para Analytics Dashboard...');

        // Preguntar si se deben limpiar datos anteriores
        $this->command->warn('⚠️  Este proceso eliminará las ventas de demostración anteriores (DEMO-*)');

        // Limpiar datos de demostración anteriores
        $this->command->info('🧹 Limpiando datos de demostración anteriores...');

        // Eliminar ventas de demostración (cascade eliminará sale_details y payments)
        Sale::where('invoice_number', 'LIKE', 'DEMO-%')->delete();
        Entry::where('invoice_number', 'LIKE', 'DEMO-%')->delete();
        Review::where('comment', 'LIKE', '%producto%')->where('created_at', '>=', Carbon::now()->subYear())->delete();

        // Deshabilitar observers temporalmente para evitar problemas con audit logs
        Product::unsetEventDispatcher();

        // Obtener usuarios y productos existentes
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Cliente');
        })->get();

        $products = Product::where('is_active', true)->limit(20)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->error('❌ No hay suficientes usuarios o productos. Ejecuta primero los seeders básicos.');
            return;
        }

        $this->command->info('📦 Generando datos históricos de 12 meses...');

        // Crear método de pago si no existe
        $paymentMethod = \App\Models\Purchase\PaymentMethod::firstOrCreate(
            ['name' => 'Efectivo'],
            ['description' => 'Pago en efectivo']
        );

        // Generar datos para los últimos 365 días (12 meses)
        $days = 365;
        $totalSales = 0;
        $totalPurchases = 0;

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            // Generar más ventas en los últimos 30 días (entre 8-15), menos en meses anteriores (3-8)
            // Generar más ventas en los últimos 30 días (entre 8-15), menos en meses anteriores (3-8)
            $salesPerDay = $i <= 30 ? rand(8, 15) : rand(3, 8);

            // Mostrar progreso solo cada 30 días
            if ($i % 30 === 0 || $i <= 7) {
                $this->command->info("📅 Procesando {$date->format('M Y')}...");
            }

            for ($j = 0; $j < $salesPerDay; $j++) {
                $customer = $customers->random();

                // Generar número de factura único con más entropía
                $invoiceNumber = 'DEMO-' . $date->format('Ymd') . '-' . uniqid() . '-' . rand(100000, 999999);

                // Crear Payment primero
                $payment = Payment::create([
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => 0, // Se actualizará después
                    'status' => 'completed',
                    'transaction_id' => 'DEMO-' . strtoupper(uniqid()),
                    'paid_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                // Crear venta
                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $customer->id,
                    'payment_id' => $payment->id,
                    'status' => 'paid',
                    'sale_type' => 'pos', // Cambiado a 'pos' (punto de venta)
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax' => 0,
                    'shipping_cost' => 0,
                    'total' => 0,
                    'currency' => 'USD',
                    'paid_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                // Agregar entre 1 y 5 productos a la venta
                $numProducts = rand(1, 5);
                $saleTotal = 0;

                for ($k = 0; $k < $numProducts; $k++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $unitPrice = $product->sale_price ?? rand(10, 100);
                    $subtotal = $quantity * $unitPrice;

                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'discount_percentage' => 0,
                        'subtotal' => $subtotal,
                    ]);

                    $saleTotal += $subtotal;

                    // Actualizar stock del producto
                    $product->decrement('stock', $quantity);
                    $product->increment('output', $quantity);
                }

                // Actualizar totales de la venta
                $sale->update([
                    'subtotal' => $saleTotal,
                    'total' => $saleTotal,
                ]);

                // Actualizar el pago
                $payment->update([
                    'amount' => $saleTotal,
                ]);

                $totalSales++;
            }

            // Generar entre 1 y 2 compras por día (menos frecuentes que ventas)
            $purchasesPerDay = rand(1, 2);

            for ($j = 0; $j < $purchasesPerDay; $j++) {
                $invoiceNumber = 'DEMO-COMP-' . $date->format('Ymd') . '-' . uniqid() . '-' . rand(100000, 999999);

                $entry = Entry::create([
                    'invoice_number' => $invoiceNumber,
                    'invoice_date' => $date->copy()->addHours(rand(8, 18)),
                    'document_type' => 'FACTURA', // Cambiado a mayúsculas
                    'total' => 0,
                    'supplier_id' => null,
                    'created_at' => $date->copy()->addHours(rand(8, 18)),
                    'updated_at' => $date->copy()->addHours(rand(8, 18)),
                ]);

                // Agregar entre 2 y 8 productos a la compra
                $numProducts = rand(2, 8);
                $entryTotal = 0;

                for ($k = 0; $k < $numProducts; $k++) {
                    $product = $products->random();
                    $quantity = rand(10, 50);
                    $price = $product->purchase_price ?? rand(5, 50);
                    $subtotal = $quantity * $price;

                    EntryDetail::create([
                        'entry_id' => $entry->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price, // Cambiado de 'cost' a 'price'
                        'subtotal' => $subtotal,
                    ]);

                    $entryTotal += $subtotal;

                    // Actualizar stock del producto
                    $product->increment('stock', $quantity);
                    $product->increment('input', $quantity);
                }

                // Actualizar total de la entrada
                $entry->update(['total' => $entryTotal]);
                $totalPurchases++;
            }
        }

        // Generar reviews para productos populares (solo últimos 60 días para ser realista)
        $this->command->info('⭐ Generando reviews de productos...');

        $reviewableProducts = $products->random(min(10, $products->count()));
        $totalReviews = 0;
        $reviewedPairs = []; // Para rastrear combinaciones user_id-product_id

        foreach ($reviewableProducts as $product) {
            $numReviews = rand(3, 8); // Entre 3 y 8 reviews por producto
            $availableCustomers = $customers->shuffle();
            $reviewsCreated = 0;

            foreach ($availableCustomers as $customer) {
                if ($reviewsCreated >= $numReviews) {
                    break;
                }

                // Verificar que no existe ya una review de este usuario para este producto
                $pairKey = $customer->id . '-' . $product->id;
                if (in_array($pairKey, $reviewedPairs)) {
                    continue;
                }

                // Verificar en la BD también
                $existingReview = Review::where('user_id', $customer->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingReview) {
                    continue;
                }

                $date = Carbon::now()->subDays(rand(0, 60)); // Reviews de últimos 60 días

                Review::create([
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Ratings entre 3 y 5 estrellas
                    'comment' => $this->getRandomComment(),
                    'status' => 'approved',
                    'helpful_count' => rand(0, 15),
                    'created_at' => $date->copy()->addHours(rand(8, 22)),
                    'updated_at' => $date->copy()->addHours(rand(8, 22)),
                ]);

                $reviewedPairs[] = $pairKey;
                $totalReviews++;
                $reviewsCreated++;
            }
        }

        // Crear algunas alertas de stock bajo
        $this->command->info('⚠️ Generando alertas de stock bajo...');

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('is_active', true)
            ->limit(5)
            ->get();

        foreach ($lowStockProducts as $product) {
            \App\Models\ReportAndAnalysis\ProductAlert::create([
                'alert_type' => 'low_stock',
                'threshold_value' => 10,
                'message' => "El producto '{$product->name}' tiene stock bajo ({$product->stock} unidades)",
                'priority' => 'high',
                'status' => 'pending',
                'product_id' => $product->id,
                'active' => true,
            ]);
        }

        $this->command->info('');
        $this->command->info('✅ Datos de demostración generados exitosamente!');
        $this->command->info("   📊 {$totalSales} ventas creadas");
        $this->command->info("   🛒 {$totalPurchases} compras creadas");
        $this->command->info("   ⭐ {$totalReviews} reviews creadas");
        $this->command->info("   ⚠️ {$lowStockProducts->count()} alertas de stock bajo");
        $this->command->info('');
        $this->command->info('🎯 Ahora puedes acceder a /dashboard para ver las métricas!');
    }

    /**
     * Genera un comentario aleatorio para las reviews
     */
    private function getRandomComment(): string
    {
        $comments = [
            'Excelente producto, muy buena calidad.',
            'Cumple con lo esperado, recomendado.',
            'Buena relación calidad-precio.',
            'Producto de calidad, llegó en buen estado.',
            'Muy satisfecho con la compra.',
            'Recomendable, volveré a comprar.',
            'Buen producto, justo lo que necesitaba.',
            'Calidad aceptable por el precio.',
            'Producto funcional y duradero.',
            'Excelente servicio y producto de calidad.',
        ];

        return $comments[array_rand($comments)];
    }
}
