<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

return function (Schedule $schedule) {
    $schedule->command('discounts:activate-deactivate')->daily();
    $schedule->command('claims:cleanup')->daily();

    // Generar registros de asistencia diarios para vendedores
    $schedule->command('attendance:generate-daily')->dailyAt('00:01');

    // Marcar como ausentes los registros sin check-in
    $schedule->command('attendance:mark-absent')->dailyAt('23:59');
};
