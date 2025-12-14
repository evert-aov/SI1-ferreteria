<?php

namespace App\Console\Commands;

use App\Models\User_security\User;
use App\Models\Attendance\AttendanceRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsentAttendances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent {--date= : Fecha específica (Y-m-d) o por defecto hoy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca automáticamente como ausentes a los vendedores que no marcaron asistencia al final del día';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Iniciando proceso de marcado automático de ausencias...');

        // Obtener fecha a procesar
        $targetDate = $this->option('date')
            ? Carbon::parse($this->option('date'))
            : now();

        $this->info("📅 Procesando fecha: {$targetDate->format('d/m/Y')}");

        // Obtener todos los vendedores activos
        $vendedores = User::with('employee')
            ->whereHas('roles', function($query) {
                $query->whereIn('name', ['Vendedor', 'Empleado']);
            })
            ->whereHas('employee', function($query) use ($targetDate) {
                $query->where(function($q) use ($targetDate) {
                    $q->whereNull('termination_date')
                      ->orWhere('termination_date', '>', $targetDate);
                });
            })
            ->get();

        $this->info("📋 Total de vendedores activos: {$vendedores->count()}");

        $markedCount = 0;
        $alreadyMarkedCount = 0;

        foreach ($vendedores as $vendedor) {
            // Buscar registro de asistencia para este día
            $attendanceRecord = AttendanceRecord::where('user_id', $vendedor->id)
                ->where('date', $targetDate->toDateString())
                ->first();

            if (!$attendanceRecord) {
                // No existe registro, crear uno como ausente
                AttendanceRecord::create([
                    'user_id' => $vendedor->id,
                    'date' => $targetDate->toDateString(),
                    'check_in_time' => null,
                    'check_out_time' => null,
                    'status' => 'absent',
                    'notes' => 'Marcado automáticamente como ausente',
                ]);

                $this->line("  ✓ Ausencia creada: {$vendedor->name} {$vendedor->last_name}");
                $markedCount++;
                continue;
            }

            // Si existe registro pero no tiene check-in, marcar como ausente
            if (!$attendanceRecord->check_in_time && $attendanceRecord->status !== 'absent') {
                $attendanceRecord->update([
                    'status' => 'absent',
                    'notes' => ($attendanceRecord->notes ?? '') . ' | Marcado como ausente automáticamente',
                ]);

                $this->line("  ✓ Actualizado a ausente: {$vendedor->name} {$vendedor->last_name}");
                $markedCount++;
            } else {
                $alreadyMarkedCount++;
            }
        }

        $this->newLine();
        $this->info("✅ Proceso completado:");
        $this->info("   • Registros marcados como ausentes: {$markedCount}");
        $this->info("   • Vendedores ya con asistencia: {$alreadyMarkedCount}");

        return Command::SUCCESS;
    }
}
