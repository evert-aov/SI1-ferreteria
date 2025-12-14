<?php

namespace App\Console\Commands;

use App\Models\User_security\User;
use App\Models\User_security\Employee;
use App\Models\Attendance\AttendanceRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateDailyAttendanceRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:generate-daily
                            {--date= : Fecha específica en formato Y-m-d (opcional, por defecto hoy)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera registros de asistencia diarios para todos los vendedores activos con estado "absent" por defecto';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : now();

        $this->info("=== GENERANDO REGISTROS DE ASISTENCIA ===");
        $this->info("Fecha: {$date->format('Y-m-d')} ({$date->isoFormat('dddd')})");

        // Obtener todos los vendedores activos
        $vendedores = User::with('employee')
            ->whereHas('roles', function($query) {
                $query->whereIn('name', ['Vendedor', 'Empleado']);
            })
            ->whereHas('employee', function($query) {
                // Solo empleados activos (sin fecha de terminación o fecha futura)
                $query->where(function($q) {
                    $q->whereNull('termination_date')
                      ->orWhere('termination_date', '>', now());
                });
            })
            ->get();

        $this->info("Vendedores activos encontrados: {$vendedores->count()}");

        if ($vendedores->isEmpty()) {
            $this->warn("⚠️  No hay vendedores activos en el sistema.");
            return 0;
        }

        $created = 0;
        $existing = 0;

        foreach ($vendedores as $vendedor) {
            // Verificar si ya existe un registro de asistencia para este día
            $existingRecord = AttendanceRecord::where('user_id', $vendedor->id)
                ->where('date', $date->toDateString())
                ->first();

            if ($existingRecord) {
                $this->warn("  ⊙ {$vendedor->name} {$vendedor->last_name} → Ya existe");
                $existing++;
                continue;
            }

            // Crear registro de asistencia con estado "absent"
            AttendanceRecord::create([
                'user_id' => $vendedor->id,
                'date' => $date->toDateString(),
                'check_in_time' => null,
                'check_out_time' => null,
                'status' => 'absent',
                'notes' => 'Generado automáticamente',
            ]);

            $this->info("  ✓ {$vendedor->name} {$vendedor->last_name} → Creado");
            $created++;
        }

        $this->newLine();
        $this->info("=== RESUMEN ===");
        $this->info("✓ Registros creados: {$created}");
        $this->info("⊙ Registros existentes (omitidos): {$existing}");
        $this->info("📊 Total de vendedores activos: " . $vendedores->count());

        return 0;
    }
}
