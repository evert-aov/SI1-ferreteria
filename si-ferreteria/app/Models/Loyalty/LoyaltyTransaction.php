<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LoyaltyTransaction extends Model
{
    protected $fillable = [
        'loyalty_account_id',
        'type',
        'points',
        'balance_after',
        'description',
        'reference_type',
        'reference_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Relación con la cuenta de lealtad
     */
    public function loyaltyAccount(): BelongsTo
    {
        return $this->belongsTo(LoyaltyAccount::class);
    }

    /**
     * Relación polimórfica con el modelo de referencia
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para puntos ganados
     */
    public function scopeEarned($query)
    {
        return $query->where('type', 'earn');
    }

    /**
     * Scope para puntos redimidos
     */
    public function scopeRedeemed($query)
    {
        return $query->where('type', 'redeem');
    }

    /**
     * Scope para puntos expirados
     */
    public function scopeExpired($query)
    {
        return $query->where('type', 'expire');
    }

    /**
     * Scope para puntos que van a expirar
     */
    public function scopeExpiring($query, int $days = 30)
    {
        return $query->where('type', 'earn')
            ->where('expires_at', '<=', now()->addDays($days))
            ->where('expires_at', '>', now());
    }

    /**
     * Obtener nombre del tipo en español
     */
    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'earn' => 'Ganado',
            'redeem' => 'Canjeado',
            'expire' => 'Expirado',
            'adjust' => 'Ajuste',
            default => 'Desconocido'
        };
    }
}
