<?php

namespace App\Models\Attendance;

use App\Models\User_security\User;
use App\Models\User_security\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
    ];

    protected $attributes = [
        'status' => 'absent',
    ];

    /**
     * Relación con el vendedor/usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con empleado
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }

    /**
     * Relación con QR tokens
     */
    public function qrTokens(): HasMany
    {
        return $this->hasMany(QrToken::class, 'attendance_record_id');
    }

    /**
     * Obtener el token QR activo
     */
    public function qrToken()
    {
        return $this->hasOne(QrToken::class, 'attendance_record_id')->where('used', false);
    }

    /**
     * Scope para filtrar por usuario (vendedor)
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope para fecha actual
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    /**
     * Scope para rango de fechas
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope para semana actual
     */
    public function scopeCurrentWeek($query)
    {
        return $query->whereBetween('date', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString()
        ]);
    }

    /**
     * Scope para mes actual
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }

    /**
     * Verificar si la asistencia fue marcada (check-in)
     */
    public function isCheckedIn(): bool
    {
        return !is_null($this->check_in_time);
    }

    /**
     * Verificar si la salida fue marcada (check-out)
     */
    public function isCheckedOut(): bool
    {
        return !is_null($this->check_out_time);
    }

    /**
     * Calcular el estado basado en el horario del empleado
     */
    public function calculateStatus(): string
    {
        if (!$this->check_in_time) {
            return 'absent';
        }

        $employee = $this->employee;
        if (!$employee || !$employee->start_time) {
            return 'present';
        }

        $scheduledStart = Carbon::parse($employee->start_time);
        $actualCheckIn = Carbon::parse($this->check_in_time);

        // Permitir 15 minutos de tolerancia
        $lateThreshold = $scheduledStart->copy()->addMinutes(15);

        if ($actualCheckIn->lte($lateThreshold)) {
            return 'on_time';
        }

        return 'late';
    }

    /**
     * Obtener badge HTML de color según estado
     */
    public function getStatusBadge(): string
    {
        return match($this->status) {
            'on_time' => '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200 rounded-full">A tiempo</span>',
            'late' => '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200 rounded-full">Tarde</span>',
            'absent' => '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-200 rounded-full">Ausente</span>',
            'present' => '<span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-200 rounded-full">Presente</span>',
            default => '<span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-200 rounded-full">Sin marcar</span>',
        };
    }

    /**
     * Calcular horas trabajadas
     */
    public function getWorkedHours(): ?float
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return null;
        }

        $checkIn = Carbon::parse($this->check_in_time);
        $checkOut = Carbon::parse($this->check_out_time);

        return $checkOut->diffInHours($checkIn, true);
    }
}
