<?php

namespace App\Models\Attendance;

use App\Models\User_security\User;
use App\Models\User_security\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Obtener el token QR activo
     */
    public function qrToken()
    {
        return $this->hasOne(QrToken::class, 'attendance_record_id')->where('used', false);
    }

    /**
     * Scope para fecha actual
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }
}
