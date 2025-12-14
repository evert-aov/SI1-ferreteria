<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceRecord;
use App\Models\Attendance\QrToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceScanController extends Controller
{
    /**
     * Muestra la página de gestión de QR para el vendedor
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener el registro de asistencia de hoy
        $today = Carbon::today();
        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // Si no existe registro para hoy, crearlo
        if (!$attendanceRecord) {
            $attendanceRecord = AttendanceRecord::create([
                'user_id' => $user->id,
                'date' => $today,
                'status' => 'absent',
            ]);
        }

        // Generar token QR si no existe o si ha expirado
        $qrToken = $attendanceRecord->qrToken;

        if (!$qrToken || $qrToken->isExpired() || $qrToken->used) {
            // Eliminar token anterior si existe
            if ($qrToken) {
                $qrToken->delete();
            }

            // Crear nuevo token válido por 5 minutos
            $qrToken = QrToken::create([
                'attendance_record_id' => $attendanceRecord->id,
                'token' => \Illuminate\Support\Str::uuid(),
                'expires_at' => Carbon::now()->addMinutes(5),
                'used' => false,
            ]);
        }

        return view('attendance.qr-manager', [
            'user' => $user,
            'attendanceRecord' => $attendanceRecord,
            'qrToken' => $qrToken,
        ]);
    }

    /**
     * Muestra la página de escaneo de QR
     */
    public function scan(Request $request)
    {
        $token = $request->query('token');
        $type = $request->query('type', 'check_in'); // Por defecto check_in

        return view('attendance.scan', [
            'token' => $token,
            'type' => $type,
        ]);
    }

    /**
     * Procesa el escaneo del código QR
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'token' => 'required|string|uuid',
            'type' => 'required|in:check_in,check_out',
        ]);

        $user = Auth::user();

        // Llamar al endpoint de la API
        $response = app(\App\Http\Controllers\Api\AttendanceController::class)
            ->markAttendance(new Request([
                'token' => $request->token,
                'user_id' => $user->id,
                'type' => $request->type,
            ]));

        $data = json_decode($response->content(), true);

        if ($data['success']) {
            return redirect()->route('attendance.index')
                ->with('success', $data['message']);
        } else {
            return redirect()->route('attendance.index')
                ->with('error', $data['message'] ?? 'Error al procesar la asistencia');
        }
    }

    /**
     * Regenera el código QR
     */
    public function regenerateQr()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($attendanceRecord) {
            // Eliminar token anterior si existe
            $attendanceRecord->qrToken?->delete();

            // Crear nuevo token
            QrToken::create([
                'attendance_record_id' => $attendanceRecord->id,
                'token' => \Illuminate\Support\Str::uuid(),
                'expires_at' => Carbon::now()->addMinutes(5),
                'used' => false,
            ]);
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Código QR regenerado correctamente');
    }
}
