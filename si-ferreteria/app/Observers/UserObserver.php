<?php

namespace App\Observers;

use App\Auditable;
use App\Models\User;

class UserObserver
{
    use Auditable;

    public function created(User $user): void
    {
        $this->logAction('created', $user, "Ha creado un nuevo usuario {$user->name}");
    }

    public function updated(User $user): void
    {
        $this->logAction('updated', $user, "Ha actualizado el usuario {$user->name}");
    }

    public function deleted(User $user): void
    {
        $this->logAction('deleted', $user, "Ha eliminado el usuario {$user->name}");
    }
}
