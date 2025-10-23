<?php

namespace App\Observers;

use App\Auditable;
use App\Models\Purchase\Entry;

class PurchaseObserver
{
    /**
     * Handle the Product "created" event.
     */
    use Auditable;
    public function created(Entry $entry): void
    {
        $this->logAction('created', $entry, "A creado la compra { $entry->invoice_number }");
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Entry $category): void
    {
        $this->logAction('updated', $category, "A actualizada la categoria { $category->invoice_number }");
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Entry $category): void
    {
        $this->logAction('deleted', $category, "A eliminada la categoria { $category->invoice_number }");
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Entry $category): void
    {
        $this->logAction('restored', $category, "A restaurada la categoria { $category->invoice_number }");
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Entry $category): void
    {
        $this->logAction('deleted', $category, "A fila eliminada la categoria { $category->invoice_number }");
    }
}
