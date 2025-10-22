<?php

namespace App\Listeners;

use App\Models\ReportAndAnalysis\AuditLog;
use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "El usuario ha iniciado sesión.",
            'affected_model' => null,
            'affected_model_id' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

