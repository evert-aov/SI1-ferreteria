<?php

namespace App\Http\Controllers;

use App\Models\User_security\Employee;
use App\Models\User_security\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Mostrar lista de empleados (solo para Administrador)
     * o redirigir a show si es empleado.
     */
    public function index()
    {
        // Verificar si el usuario es administrador
        $isAdmin = Auth::user()->roles->contains('name', 'Administrador');

        if (!$isAdmin) {
            // Si es vendedor/empleado, redirigir a su propio perfil
            $hasEmployeeRole = Auth::user()->roles->whereIn('name', ['Vendedor', 'Empleado'])->count() > 0;

            if ($hasEmployeeRole) {
                // Redirigir a su propio perfil
                return redirect()->route('employees.show', Auth::id());
            }

            // Si no es empleado ni admin, denegar acceso
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Si es administrador, mostrar todos los usuarios con rol Vendedor o Empleado
        $employees = User::with(['roles', 'employee'])
            ->whereHas('roles', function($query) {
                $query->whereIn('name', ['Vendedor', 'Empleado']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('employees.index', compact('employees'));
    }

    /**
     * Mostrar información de un empleado específico
     */
    public function show($id)
    {
        $user = User::with(['roles', 'employee'])->findOrFail($id);

        // Verificar que el usuario tenga rol de Vendedor o Empleado
        $hasEmployeeRole = $user->roles->whereIn('name', ['Vendedor', 'Empleado'])->count() > 0;

        if (!$hasEmployeeRole) {
            abort(404, 'Este usuario no es un empleado.');
        }

        // Verificar si el usuario actual es administrador
        $isAdmin = Auth::user()->roles->contains('name', 'Administrador');

        // Si no es admin, solo puede ver su propio perfil
        if (!$isAdmin && $user->id !== Auth::id()) {
            abort(403, 'No tienes permisos para ver la información de otros empleados.');
        }

        // Obtener registros de asistencia de los últimos 30 días
        $attendanceRecords = \App\Models\Attendance\AttendanceRecord::where('user_id', $user->id)
            ->whereBetween('date', [now()->subDays(30), now()])
            ->orderBy('date', 'desc')
            ->get();

        // Calcular estadísticas de asistencia
        $attendanceStats = $this->calculateAttendanceStats($user, $attendanceRecords);

        return view('employees.show', compact('user', 'isAdmin', 'attendanceRecords', 'attendanceStats'));
    }

    /**
     * Calcular estadísticas de asistencia del empleado
     */
    private function calculateAttendanceStats($user, $attendanceRecords)
    {
        $totalDays = $attendanceRecords->count();
        $onTime = $attendanceRecords->where('status', 'on_time')->count();
        $late = $attendanceRecords->where('status', 'late')->count();
        $absent = $attendanceRecords->where('status', 'absent')->count();
        $present = $attendanceRecords->where('status', 'present')->count();

        $totalMinutesWorked = 0;
        $totalMinutesExpected = 0;
        $extraMinutes = 0;
        $missingMinutes = 0;

        if ($user->employee && $user->employee->start_time && $user->employee->end_time) {
            // Parsear horario como Carbon para obtener hora y minutos correctamente
            $startTime = \Carbon\Carbon::parse($user->employee->start_time);
            $endTime = \Carbon\Carbon::parse($user->employee->end_time);

            $startMinutes = ($startTime->hour * 60) + $startTime->minute;
            $endMinutes = ($endTime->hour * 60) + $endTime->minute;

            // Si el horario cruza la medianoche (ej: 22:00 a 06:00)
            if ($endMinutes < $startMinutes) {
                $expectedMinutesPerDay = (1440 - $startMinutes) + $endMinutes; // 1440 = minutos en un día
            } else {
                $expectedMinutesPerDay = $endMinutes - $startMinutes;
            }

            foreach ($attendanceRecords as $record) {
                // Solo contar días que no sean ausencias completas
                if ($record->status !== 'absent') {
                    $totalMinutesExpected += $expectedMinutesPerDay;

                    if ($record->check_in_time && $record->check_out_time) {
                        // Calcular minutos trabajados
                        $checkInMinutes = ($record->check_in_time->hour * 60) + $record->check_in_time->minute;
                        $checkOutMinutes = ($record->check_out_time->hour * 60) + $record->check_out_time->minute;
                        $workedMinutes = $checkOutMinutes - $checkInMinutes;

                        // Si trabajó pasando medianoche
                        if ($workedMinutes < 0) {
                            $workedMinutes += 1440;
                        }

                        $totalMinutesWorked += $workedMinutes;

                        // Calcular horas extras o faltantes por día
                        $diff = $workedMinutes - $expectedMinutesPerDay;
                        if ($diff > 0) {
                            $extraMinutes += $diff;
                        } else {
                            $missingMinutes += abs($diff);
                        }
                    } else {
                        // Si no marcó salida, todo el día es faltante
                        $missingMinutes += $expectedMinutesPerDay;
                    }
                }
            }
        }

        return [
            'total_days' => $totalDays,
            'on_time' => $onTime,
            'late' => $late,
            'absent' => $absent,
            'present' => $present,
            'total_hours_worked' => round($totalMinutesWorked / 60, 2),
            'total_hours_expected' => round($totalMinutesExpected / 60, 2),
            'extra_hours' => round($extraMinutes / 60, 2),
            'missing_hours' => round($missingMinutes / 60, 2),
            'on_time_percentage' => $totalDays > 0 ? round(($onTime / $totalDays) * 100, 1) : 0,
            'attendance_percentage' => $totalDays > 0 ? round((($totalDays - $absent) / $totalDays) * 100, 1) : 0,
        ];
    }

    /**
     * Actualizar información del empleado (solo administrador)
     */
    public function update(Request $request, $id)
    {
        // Verificar que sea administrador
        if (!Auth::user()->roles->contains('name', 'Administrador')) {
            abort(403, 'No tienes permisos para editar empleados.');
        }

        $user = User::with('employee')->findOrFail($id);

        // Validar datos
        $validated = $request->validate([
            'salary' => 'nullable|numeric|min:0|max:999999.99',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date|after_or_equal:hire_date',
        ], [
            'salary.numeric' => 'El salario debe ser un número válido.',
            'salary.min' => 'El salario no puede ser negativo.',
            'salary.max' => 'El salario excede el límite permitido.',
            'start_time.date_format' => 'El formato de hora de inicio debe ser HH:MM.',
            'end_time.date_format' => 'El formato de hora de fin debe ser HH:MM.',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'hire_date.date' => 'La fecha de contratación no es válida.',
            'termination_date.date' => 'La fecha de terminación no es válida.',
            'termination_date.after_or_equal' => 'La fecha de terminación debe ser posterior o igual a la fecha de contratación.',
        ]);

        // Crear o actualizar registro de empleado
        if ($user->employee) {
            $user->employee->update($validated);
        } else {
            Employee::create(array_merge($validated, ['user_id' => $user->id]));
        }

        return redirect()->route('employees.show', $id)
            ->with('success', 'Información del empleado actualizada correctamente.');
    }
}
