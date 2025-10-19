<?php

namespace App\Observers;

use App\Auditable;
use App\Models\Product;

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
}
