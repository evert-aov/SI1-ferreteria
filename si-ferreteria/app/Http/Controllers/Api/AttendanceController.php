<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceRecord;
use App\Models\Attendance\QrToken;
use App\Models\User_security\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Marca la asistencia de un vendedor escaneando un código QR
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAttendance(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|uuid',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:check_in,check_out', // Tipo de marcado
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 1. Verificar que el token existe
            $qrToken = QrToken::with('attendanceRecord')->where('token', $request->token)->first();

            if (!$qrToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código QR inválido'
                ], 404);
            }

            // 2. Verificar que el token no ha sido usado
            if ($qrToken->used) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este código QR ya ha sido usado'
                ], 400);
            }

            // 3. Verificar que el token no ha expirado
            if ($qrToken->isExpired()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este código QR ha expirado'
                ], 400);
            }

            // 4. Obtener el registro de asistencia
            $attendanceRecord = $qrToken->attendanceRecord;

            if (!$attendanceRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay registro de asistencia asociado a este código'
                ], 400);
            }

            // 5. Verificar que el usuario coincide
            if ($attendanceRecord->user_id != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este código QR no corresponde a tu usuario'
                ], 400);
            }

            // 6. Verificar que el registro es para hoy
            if (!$attendanceRecord->date->isToday()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este código QR no es válido para el día de hoy'
                ], 400);
            }

            // 7. Obtener información del empleado para validar horario
            $employee = Employee::where('user_id', $request->user_id)->first();

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró información de empleado'
                ], 400);
            }

            $now = Carbon::now();

            // 8. Procesar según el tipo de marcado
            if ($request->type === 'check_in') {
                // Verificar que no haya marcado ya entrada
                if ($attendanceRecord->check_in_time) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya has marcado tu entrada para hoy'
                    ], 400);
                }

                // Calcular el estado basado en el horario
                $status = 'present';
                if ($employee->start_time) {
                    $scheduledStart = Carbon::parse($employee->start_time);
                    $lateThreshold = $scheduledStart->copy()->addMinutes(15);

                    if ($now->lte($lateThreshold)) {
                        $status = 'on_time';
                    } else {
                        $status = 'late';
                    }
                }

                // Actualizar registro con check-in
                $attendanceRecord->update([
                    'check_in_time' => $now,
                    'status' => $status,
                ]);

                $message = match($status) {
                    'on_time' => '¡Asistencia marcada a tiempo!',
                    'late' => 'Asistencia marcada con retraso',
                    default => 'Asistencia marcada',
                };

            } else { // check_out
                // Verificar que ya haya marcado entrada
                if (!$attendanceRecord->check_in_time) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Debes marcar tu entrada primero'
                    ], 400);
                }

                // Verificar que no haya marcado ya salida
                if ($attendanceRecord->check_out_time) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya has marcado tu salida para hoy'
                    ], 400);
                }

                // Actualizar registro con check-out
                $attendanceRecord->update([
                    'check_out_time' => $now,
                ]);

                $message = '¡Salida registrada correctamente!';
            }

            // 9. Marcar el token como usado
            $qrToken->markAsUsed();

            // 10. Responder con éxito
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'status' => $attendanceRecord->status,
                    'check_in_time' => $attendanceRecord->check_in_time?->format('H:i'),
                    'check_out_time' => $attendanceRecord->check_out_time?->format('H:i'),
                    'date' => $attendanceRecord->date->format('d/m/Y'),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar la asistencia: ' . $e->getMessage()
            ], 500);
        }
    }
}
