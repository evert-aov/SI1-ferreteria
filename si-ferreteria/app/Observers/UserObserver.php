<?php

namespace App\Observers;

use App\Auditable;
use App\Models\ReportAndAnalysis\AuditLog;
use App\Models\User_security\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    use Auditable;

    public function created(User $user): void
    {
        //$this->logAction('created', $user, "Ha creado un nuevo usuario {$user->name}");
        $userId = Auth::id() ?? $user->id;

        AuditLog::create([
            'user_id' => $userId,
            'action' => 'Ha creado un nuevo usuario ' . $user->name,
            'affected_model' => User::class,
            'affected_model_id' => $user->id,
            'changes' => json_encode([
                'before' => [],
                'after' => $user->only([
                    'name',
                    'last_name',
                    'email',
                    'document_type',
                    'document_number',
                    'gender',
                    'status'
                ])
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
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
