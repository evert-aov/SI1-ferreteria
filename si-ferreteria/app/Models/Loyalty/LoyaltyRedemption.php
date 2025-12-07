<?php

namespace App\Models\Loyalty;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LoyaltyRedemption extends Model
{
    protected $fillable = [
        'loyalty_account_id',
        'loyalty_reward_id',
        'points_spent',
        'sale_id',
        'status',
        'coupon_code',
        'expires_at',
        'code',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($redemption) {
            if (empty($redemption->code)) {
                $redemption->code = 'LOY-' . strtoupper(Str::random(8));
            }
            
            if (empty($redemption->expires_at)) {
                $redemption->expires_at = now()->addDays(30); // Cupón válido por 30 días
            }
        });
    }

    /**
     * Relación con la cuenta de lealtad
     */
    public function loyaltyAccount(): BelongsTo
    {
        return $this->belongsTo(LoyaltyAccount::class);
    }

    /**
     * Relación con la recompensa
     */
    public function loyaltyReward(): BelongsTo
    {
        return $this->belongsTo(LoyaltyReward::class);
    }

    /**
     * Relación con la venta donde se aplicó
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Scope para canjes pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending')
            ->where('expires_at', '>', now());
    }

    /**
     * Scope para canjes aplicados
     */
    public function scopeApplied($query)
    {
        return $query->where('status', 'applied');
    }

    /**
     * Scope para canjes expirados
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
            ->orWhere(function ($q) {
                $q->where('status', 'pending')
                  ->where('expires_at', '<=', now());
            });
    }

    /**
     * Marcar como aplicado
     */
    public function markAsApplied(Sale $sale): void
    {
        $this->update([
            'status' => 'applied',
            'sale_id' => $sale->id,
        ]);
    }

    /**
     * Verificar si está expirado
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->status === 'pending' && $this->expires_at < now());
    }

    /**
     * Obtener nombre del estado en español
     */
    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'applied' => 'Aplicado',
            'expired' => 'Expirado',
            'cancelled' => 'Cancelado',
            default => 'Desconocido'
        };
    }
}
