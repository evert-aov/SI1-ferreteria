<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoyaltyReward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'points_cost',
        'reward_type',
        'reward_value',
        'is_active',
        'stock_limit',
        'available_count',
        'minimum_level',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'reward_value' => 'decimal:2',
    ];

    /**
     * Relación con canjes
     */
    public function redemptions(): HasMany
    {
        return $this->hasMany(LoyaltyRedemption::class);
    }

    /**
     * Scope para recompensas activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para recompensas disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('stock_limit')
                  ->orWhere('available_count', '>', 0);
            });
    }

    /**
     * Scope para filtrar por nivel mínimo
     */
    public function scopeForLevel($query, string $level)
    {
        $levels = ['bronze' => 1, 'silver' => 2, 'gold' => 3];
        $minLevel = $levels[$level] ?? 1;

        return $query->where(function ($q) use ($minLevel) {
            if ($minLevel >= 3) {
                $q->whereIn('minimum_level', ['bronze', 'silver', 'gold']);
            } elseif ($minLevel >= 2) {
                $q->whereIn('minimum_level', ['bronze', 'silver']);
            } else {
                $q->where('minimum_level', 'bronze');
            }
        });
    }

    /**
     * Verificar si la recompensa está disponible
     */
    public function isAvailable(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->stock_limit !== null && $this->available_count <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Decrementar stock disponible
     */
    public function decrementStock(): void
    {
        if ($this->stock_limit !== null) {
            $this->decrement('available_count');
        }
    }

    /**
     * Obtener nombre del tipo en español
     */
    public function getTypeNameAttribute(): string
    {
        return match($this->reward_type) {
            'discount_percentage' => 'Descuento Porcentual',
            'discount_amount' => 'Descuento Fijo',
            'free_product' => 'Producto Gratis',
            default => 'Desconocido'
        };
    }

    /**
     * Obtener descripción del valor
     */
    public function getValueDescriptionAttribute(): string
    {
        return match($this->reward_type) {
            'discount_percentage' => $this->reward_value . '% de descuento',
            'discount_amount' => '$' . number_format($this->reward_value, 2) . ' de descuento',
            'free_product' => 'Producto gratis',
            default => ''
        };
    }
}
