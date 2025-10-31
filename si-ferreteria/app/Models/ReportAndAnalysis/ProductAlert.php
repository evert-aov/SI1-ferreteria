<?php

namespace App\Models\ReportAndAnalysis;


use App\Models\Inventory\Product;
use App\Models\User_security\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAlert extends Model
{
    protected $fillable = [
        'alert_type',
        'threshold_value',
        'message',
        'priority',
        'status',
        'visible_to',
        'user_id',
        'product_id',
        'active',
    ];

    protected $casts = [
        'visible_to' => 'array',
        'threshold_value' => 'double',
        'active' => 'boolean',
    ];

    /**
     * Relación con Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con Producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Scope: Alertas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope: Alertas pendientes (status='pending' Y active=true)
     */
    public function scopePendientes($query)
    {
        return $query->where('status', 'pending')
                     ->where('active', true);
    }

    /**
     * Scope: Alertas para un rol específico
     */
    public function scopeVisiblePara($query, $rol)
    {
        return $query->whereJsonContains('visible_to', $rol);
    }

    /**
     * Scope: Alertas de un usuario
     */
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Alertas del sistema (sin usuario específico)
     */
    public function scopeDelSistema($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope: Por tipo de alerta
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('alert_type', $tipo);
    }

    /**
     * Scope: Por prioridad
     */
    public function scopePrioridad($query, $prioridad)
    {
        return $query->where('priority', $prioridad);
    }

    /**
     * Marcar como leída
     */
    public function marcarComoLeida(): void
    {
        $this->update(['status' => 'read']);
    }

    /**
     * Marcar como ignorada
     */
    public function ignorar(): void
    {
        $this->update(['status' => 'ignored']);
    }

    /**
     * Verificar si es visible para un rol
     */
    public function esVisiblePara(string $rol): bool
    {
        return in_array($rol, $this->visible_to);
    }

    /**
     * Obtener color según prioridad
     */
    public function getColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'blue',
            default => 'blue'
        };
    }
}
