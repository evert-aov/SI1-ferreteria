<?php

namespace App\Services;

use App\Models\Inventory\Product;
use App\Models\ReportAndAnalysis\ProductAlert;
use App\Livewire\ReportAndAnalysis\ProductAlertManager;
use Carbon\Carbon;

class ProductAlertService
{
    /**
     * Genera alertas automáticas sin guardarlas en la BD.
     * Retorna un array de alertas listas para mostrar.
     */
    public function runAllChecks(): array
    {
        return array_merge(
            $this->checkVencimientoProximo(),
            $this->checkVencido(),
            $this->checkBajoStock(),
            $this->checkSinStock(),
        );
    }

    /**
     * Devuelve todas las alertas manuales activas desde la BD en formato unificado.
     */
    public function getManualAlerts(): array
    {
        $manualAlerts = ProductAlert::activas()
            ->pendientes()
            ->whereNotNull('user_id') // solo manuales
            ->with('producto')
            ->get();

        return $manualAlerts->map(fn($alert) => $this->formatAlert($alert))->toArray();
    }

    /**
     * Vencimiento próximo
     */
    public function checkVencimientoProximo(int $dias = 30): array
    {
        $now = now();
        $future = $now->clone()->addDays($dias);

        $products = Product::active()
            ->whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [$now, $future])
            ->get();

        $alerts = [];
        foreach ($products as $product) {
            $daysRemaining = (int) $now->diffInDays($product->expiration_date);
            $priority = match (true) {
                $daysRemaining <= 7 => 'high',
                $daysRemaining <= 15 => 'medium',
                default => 'low'
            };

            $alerts[] = $this->makeAlert($product, 'upcoming_expiration', [
                'message' => "{$product->name} vence en {$daysRemaining} " . ($daysRemaining === 1 ? 'día' : 'días'),
                'priority' => $priority,
            ]);
        }

        return $alerts;
    }

    /**
     * Productos vencidos
     */
    public function checkVencido(): array
    {
        $now = now();
        $products = Product::active()
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', $now)
            ->get();

        $alerts = [];
        foreach ($products as $product) {
            $daysExpired = (int) $now->diffInDays($product->expiration_date);
            $alerts[] = $this->makeAlert($product, 'expired', [
                'message' => "{$product->name} venció hace {$daysExpired} " . ($daysExpired === 1 ? 'día' : 'días'),
                'priority' => 'high',
            ]);
        }

        return $alerts;
    }

    /**
     * Bajo stock
     */
    public function checkBajoStock(int $umbral = 150): array
    {
        $products = Product::active()->where('stock', '<=', $umbral)->get();
        $alerts = [];

        foreach ($products as $product) {
            $priority = match (true) {
                $product->stock <= 10 => 'high',
                $product->stock <= 50 => 'medium',
                default => 'low'
            };

            $alerts[] = $this->makeAlert($product, 'low_stock', [
                'message' => "{$product->name} tiene bajo stock: {$product->stock} unidades (umbral: {$umbral})",
                'priority' => $priority,
            ]);
        }

        return $alerts;
    }

    /**
     * Sin stock
     */
    public function checkSinStock(): array
    {
        $products = Product::active()->where('stock', 0)->get();
        $alerts = [];

        foreach ($products as $product) {
            $alerts[] = $this->makeAlert($product, 'out_of_stock', [
                'message' => "{$product->name} no tiene stock disponible",
                'priority' => 'high',
            ]);
        }

        return $alerts;
    }

    /**
     * Construye una alerta de producto (automática o manual)
     */
    protected function makeAlert($product, string $type, array $data): array
    {
        return [
            'product_id' => $product->id,
            'alert_type' => $type,
            'message' => $data['message'] ?? '',
            'priority' => $data['priority'] ?? 'low',
            'color' => $this->getColorByPriority($data['priority'] ?? 'low'),
            'titulo' => $this->getTitulo($type),
        ];
    }

    /**
     * Convierte cualquier alerta (manual de BD o automática) al formato que espera el Toast
     */
    public function formatAlert($alert): array
    {
        return [
            'id' => 'alert-' . ($alert->id ?? uniqid()),
            'titulo' => $alert['titulo'] ?? $this->getTitulo($alert['alert_type']),
            'descripcion' => $alert['message'] ?? '',
            'tipo' => $this->getTipoByPriority($alert['priority'] ?? 'low'),
            'color' => $alert['color'] ?? $this->getColorByPriority($alert['priority'] ?? 'low'),
            'duracion' => match($alert['priority'] ?? 'low') {
                'high' => 0,
                'medium' => 15000,
                default => 10000,
            },
            'autoCierre' => ($alert['priority'] ?? 'low') !== 'high',
        ];
    }

    protected function getColorByPriority(string $priority): string
    {
        return match ($priority) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'blue',
        };
    }

    protected function getTitulo(string $type): string
    {
        return match ($type) {
            'expired' => '🚨 Producto vencido',
            'upcoming_expiration' => '⚠️ Próximo a vencer',
            'low_stock' => '📦 Bajo stock',
            'out_of_stock' => '❌ Sin stock',
            default => '🔔 Alerta de producto',
        };
    }

     protected function getTipoByPriority(string $priority): string
    {
        return match ($priority) {
            'high' => 'error',
            'medium' => 'warning',
            'low' => 'info',
            default => 'info',
        };
    }

    /**
     * Ejecuta las verificaciones de stock y devuelve los toasts listos.
     */
    public function runStockCheckAutomatic(): array
    {
        $alerts = array_merge(
            $this->checkBajoStock(),
            $this->checkSinStock()
        );

        $toasts = [];
        foreach ($alerts as $alert) {
            $toasts[] = $this->formatAlert($alert);
        }

        echo "Se generaron " . count($toasts) . " alertas de stock.\n";

        return $toasts;
    }

    /**
     * Ejecuta las verificaciones de vencimiento y devuelve los toasts listos.
     */
    public function runExpirationCheckAutomatic(): array
    {
        $alerts = array_merge(
            $this->checkVencido(),
            $this->checkVencimientoProximo()
        );

        $toasts = [];
        foreach ($alerts as $alert) {
            $toasts[] = $this->formatAlert($alert);
        }

        echo "Se generaron " . count($toasts) . " alertas de vencimiento.\n";

        return $toasts;
    }
}
