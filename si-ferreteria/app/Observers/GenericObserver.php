<?php

namespace App\Observers;

use App\Auditable;

class GenericObserver
{
    use Auditable;

    public function created($model): void
    {
        $this->logAction('created', $model);
    }

    public function updated($model): void
    {
        $this->logAction('updated', $model);
    }

    public function deleted($model): void
    {
        $this->logAction('deleted', $model);
    }
}
