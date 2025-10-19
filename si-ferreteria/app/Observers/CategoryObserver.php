<?php

namespace App\Observers;

use App\Auditable;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Product "created" event.
     */
    use Auditable;
    public function created(Category $category): void
    {
        $this->logAction('created', $category, "A creado la categoria { $category->name }");
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->logAction('updated', $category, "A actualizada la categoria { $category->name }");
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->logAction('deleted', $category, "A eliminada la categoria { $category->name }");
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->logAction('restored', $category, "A restaurada la categoria { $category->name }");
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->logAction('deleted', $category, "A fila eliminada la categoria { $category->name }");
    }
}
