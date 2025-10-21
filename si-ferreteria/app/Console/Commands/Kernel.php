<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define la programación de comandos del sistema.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('alerts:check')->hourly();
    }

    /**
     * Registra los comandos Artisan personalizados.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
