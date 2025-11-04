<?php

namespace App\Services;

use App\Models\Inventory\Product;

class ProductAlertService
{

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
            $daysExpired = abs((int) $now->diffInDays($product->expiration_date));
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
            $alerts[] = $this->makeAlert($product, 'out_of_stock',
            [
                'message' => "{$product->name} no tiene stock disponible",
                'priority' => 'high',
            ]);
        }

        return $alerts;
    }

    /**
     * Construye una alerta simple con los datos necesarios
     */
    protected function makeAlert($product, string $type, array $data): array
    {
        return [
            'product_id' => $product->id,
            'message' => $data['message'] ?? '',
            'priority' => $data['priority'] ?? 'low',
            'titulo' => $this->getTitulo($type),
        ];
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

}
