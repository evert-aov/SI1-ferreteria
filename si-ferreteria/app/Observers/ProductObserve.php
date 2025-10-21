<?php

namespace App\Observers;

use App\Auditable;
use App\Models\Product;
use App\Models\ProductAlert;

class ProductObserve
{
    /**
     * Handle the Product "created" event.
     */
    use Auditable;
    public function created(Product $product): void
    {
        $this->logAction('created', $product, "A creado al producto { $product->name }");
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->logAction('updated', $product, "A actualizada al producto { $product->name }");

        // Re-evaluar alertas manuales configuradas para este producto
        $this->reevaluateProductAlerts($product);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->logAction('deleted', $product, "A eliminada al producto { $product->name }");
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->logAction('restored', $product, "A restaurada al producto { $product->name }");
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->logAction('deleted', $product, "A fila eliminada al producto { $product->name }");
    }

    /**
     * Re-evaluar y activar/desactivar alertas según las condiciones actuales del producto
     */
    protected function reevaluateProductAlerts(Product $product): void
    {
        // Obtener todas las alertas MANUALES (creadas por usuarios) para este producto
        $alerts = ProductAlert::where('product_id', $product->id)
            ->whereNotNull('user_id') // Solo alertas manuales
            ->get();

        foreach ($alerts as $alert) {
            $shouldBeActive = true;

            // Evaluar según el tipo de alerta
            switch ($alert->alert_type) {
                case 'low_stock':
                    // Activar si el stock actual está por debajo o igual al umbral
                    $shouldBeActive = ($product->stock <= $alert->threshold_value);
                    break;

                case 'upcoming_expiration':
                    // Activar si faltan los días indicados o menos para el vencimiento
                    if ($product->expiration_date) {
                        $daysRemaining = now()->diffInDays($product->expiration_date, false);
                        $shouldBeActive = ($daysRemaining >= 0 && $daysRemaining <= $alert->threshold_value);
                    } else {
                        // Si no hay fecha de expiración, desactivar
                        $shouldBeActive = false;
                    }
                    break;

                case 'out_of_stock':
                    // Activar si el stock es 0
                    $shouldBeActive = ($product->stock == 0);
                    break;

                case 'expired':
                    // Activar si el producto ya venció
                    if ($product->expiration_date) {
                        $shouldBeActive = now()->isAfter($product->expiration_date);
                    } else {
                        $shouldBeActive = false;
                    }
                    break;

                default:
                    $shouldBeActive = true;
                    break;
            }

            // Actualizar el estado de la alerta solo si cambió
            if ($alert->active !== $shouldBeActive) {
                $alert->update(['active' => $shouldBeActive]);
            }
        }
    }

    /**
     *  Verificar condiciones automáticas (alertas del sistema).
     */
    protected function checkAutomaticAlerts(Product $product): void
    {
        if ($product->expiration_date) {
            $expiration = Carbon::parse($product->expiration_date);

            if ($expiration->isPast()) {
                $this->dispatchLivewireAlert('Producto vencido', "El producto '{$product->name}' ya está vencido", 'red');
            }
        }

        if ($product->stock == 0) {
            $this->dispatchLivewireAlert('Sin stock', "El producto '{$product->name}' se quedó sin stock", 'red');
        }
    }



     /**
     *  Disparar evento Livewire (para toasts en tiempo real).
     */
    protected function dispatchLivewireAlert(string $titulo, string $mensaje, string $color): void
    {
        try {
            Livewire::dispatch('product-expired-detected', $titulo, $mensaje, $color);
        } catch (Throwable $e) {
            // Manejar error si Livewire no está disponible
            Log::error("Error dispatching Livewire alert: " . $e->getMessage());
        }
    }
}
