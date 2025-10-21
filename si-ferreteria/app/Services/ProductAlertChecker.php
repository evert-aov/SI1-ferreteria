<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductAlert;
use Carbon\Carbon;

/**
 * Servicio para generar alertas de productos
 * Cada método verifica condiciones y crea registros en product_alerts
 */
class ProductAlertChecker
{
    /**
     * VENCIMIENTO PRÓXIMO
     * Productos que vencen en los próximos X días
     */
    public function checkVencimientoProximo(int $dias = 30): void
    {
        $now = Carbon::now();
        $futureDate = $now->copy()->addDays($dias);

        $products = Product::active()
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<=', $futureDate)
            ->where('expiration_date', '>', $now)
            ->get();

        foreach ($products as $product) {
            // Verificar si ya existe una alerta pendiente para este producto
            $existingAlert = ProductAlert::activas()
                ->pendientes()
                ->where('product_id', $product->id)
                ->where('alert_type', 'upcoming_expiration')
                ->first();

            if (!$existingAlert) {
                $daysRemaining = (int) ceil($now->diffInDays($product->expiration_date, false));

                // Prioridad según días restantes
                $priority = match(true) {
                    $daysRemaining <= 7 => 'high',
                    $daysRemaining <= 15 => 'medium',
                    default => 'low'
                };

                $this->createSystemAlert($product, 'upcoming_expiration', [
                    'threshold_value' => $daysRemaining,
                    'message' => "{$product->name} vence en {$daysRemaining} " . ($daysRemaining === 1 ? 'día' : 'días'),
                    'priority' => $priority,
                ]);
            }
        }
    }

    /**
     * VENCIDO
     * Productos ya vencidos
     */
    public function checkVencido(): void
    {
        $now = Carbon::now();

        $products = Product::active()
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', $now)
            ->get();

        foreach ($products as $product) {
            $existingAlert = ProductAlert::activas()
                ->pendientes()
                ->where('product_id', $product->id)
                ->where('alert_type', 'expired')
                ->first();

            if (!$existingAlert) {
                $daysExpired = (int) ceil(abs($now->diffInDays($product->expiration_date, false)));

                $this->createSystemAlert(
                    $product, 'expired', [
                    'threshold_value' => $daysExpired,
                    'message' => "{$product->name} venció hace {$daysExpired} " . ($daysExpired === 1 ? 'día' : 'días'),
                    'priority' => 'high',
                ]);
            }
        }
    }


    protected function createSystemAlert(Product $product, string $type, array $data): void
    {
        ProductAlert::create(array_merge([
            'alert_type' => $type,
            'threshold_value' => $data['threshold_value'] ?? null,
            'message' => $data['message'] ?? "{$product->name} tiene una alerta de tipo {$type}",
            'priority' => $data['priority'] ?? 'high',
            'status' => 'pending',
            'visible_to' => ['Administrador', 'Vendedor'],
            'user_id' => null,
            'product_id' => $product->id,
            'active' => true,
        ], $data));
    }


    /**
     * BAJO STOCK V1
     * Crea alertas automáticas de bajo stock para productos cuyo stock está por debajo del umbral definido (ej: 150)
     */
    public function checkBajoStock(int $umbral = 150): void
    {
        $products = Product::active()
            ->where('stock', '<=', $umbral)
            ->get();

        foreach ($products as $product) {
            $existingAlert = ProductAlert::activas()
                ->pendientes()
                ->where('product_id', $product->id)
                ->where('alert_type', 'low_stock')
                ->whereNull('user_id') // Solo automáticas
                ->first();

            if (!$existingAlert) {
                $priority = match(true) {
                    $product->stock <= 10 => 'high',
                    $product->stock <= 50 => 'medium',
                    default => 'low'
                };

                $this->createSystemAlert($product, 'low_stock', [
                    'threshold_value' => $umbral,
                    'message' => "{$product->name} tiene bajo stock: {$product->stock} unidades (umbral: {$umbral})",
                    'priority' => $priority,
                ]);
            }
        }
    }

    /**
     * BAJO STOCK
     * Verifica stock contra alertas configuradas por usuarios
     */
    public function checkBajoStockV1(): void
    {
        // Obtener todas las configuraciones de bajo stock (activas e inactivas)
        $lowStockConfigs = ProductAlert::tipo('low_stock')
            ->whereNotNull('user_id') // Solo configuradas por usuarios
            ->whereNotNull('threshold_value')
            ->get();

        foreach ($lowStockConfigs as $config) {
            $product = $config->producto;

            if (!$product) continue;

            // Verificar si el stock actual está por debajo o igual al umbral
            if ($product->stock <= $config->threshold_value) {
                if (!$config->active) {
                    $config->update([
                        'active' => true,
                        'status' => 'pending',
                        'message' => "{$product->name} llegó al umbral: {$product->stock} unidades (umbral: {$config->threshold_value})"
                    ]);
                }
            } else {
                if ($config->active) {
                    $config->update(['active' => false]);
                }
            }
        }
    }

    /**
     * SIN STOCK
     * Productos con stock = 0
     */
    public function checkSinStock(): void
    {
        $products = Product::active()
            ->where('stock', 0)
            ->get();

        foreach ($products as $product) {
            $existingAlert = ProductAlert::activas()
                ->pendientes()
                ->where('product_id', $product->id)
                ->where('alert_type', 'out_of_stock')
                ->first();

            if (!$existingAlert) {
                $this->createSystemAlert($product, 'out_of_stock', [
                    'message' => "{$product->name} no tiene stock disponible",
                    'priority' => 'high',
                ]);
            }
        }
    }


    /**
     * LIMPIAR ALERTAS RESUELTAS
     * Marca como 'read' alertas que ya no aplican
     */
    public function cleanResolvedAlerts(): void
    {
        $now = Carbon::now();

        // 1. Alertas de vencimiento próximo para productos ya vencidos
        $upcomingExpired = ProductAlert::activas()
            ->pendientes()
            ->tipo('upcoming_expiration')
            ->whereHas('producto', function($q) use ($now) {
                $q->where('expiration_date', '<', $now);
            })
            ->get();

        foreach ($upcomingExpired as $alert) {
            $alert->marcarComoLeida();
        }

        // 2. Alertas de vencimiento próximo para productos con fecha lejana
        $upcomingFar = ProductAlert::activas()
            ->pendientes()
            ->tipo('upcoming_expiration')
            ->whereHas('producto', function($q) use ($now) {
                $q->where('expiration_date', '>', $now->copy()->addDays(30));
            })
            ->get();

        foreach ($upcomingFar as $alert) {
            $alert->marcarComoLeida();
        }

        // 3. Alertas de sin stock para productos con stock
        $outOfStockResolved = ProductAlert::activas()
            ->pendientes()
            ->tipo('out_of_stock')
            ->whereHas('producto', function($q) {
                $q->where('stock', '>', 0);
            })
            ->get();

        foreach ($outOfStockResolved as $alert) {
            $alert->marcarComoLeida();
        }

        // 4. Alertas de bajo stock cuando el stock se ha repuesto
        $lowStockResolved = ProductAlert::activas()
            ->pendientes()
            ->tipo('low_stock')
            ->whereNull('user_id') // Solo automáticas
            ->get();

        foreach ($lowStockResolved as $alert) {
            $product = $alert->producto;
            if ($product && $product->stock > ($alert->threshold_value ?? 150)) {
                $alert->marcarComoLeida();
            }
        }

        // 5. Alertas huérfanas (producto eliminado)
        $orphanAlerts = ProductAlert::activas()
            ->pendientes()
            ->whereNotNull('product_id')
            ->whereDoesntHave('producto')
            ->get();

        foreach ($orphanAlerts as $alert) {
            $alert->marcarComoLeida();
        }
    }
}
