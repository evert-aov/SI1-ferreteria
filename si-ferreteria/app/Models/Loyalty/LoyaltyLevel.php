<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoyaltyLevel extends Model
{
    protected $fillable = [
        'code',
        'name',
        'min_points',
        'multiplier',
        'color',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'min_points' => 'integer',
        'multiplier' => 'decimal:2',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con cuentas de lealtad
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(LoyaltyAccount::class, 'membership_level', 'code');
    }

    /**
     * Obtener nivel según puntos totales
     */
    public static function getLevelForPoints(int $points): ?self
    {
        return self::where('is_active', true)
            ->where('min_points', '<=', $points)
            ->orderBy('min_points', 'desc')
            ->first();
    }

    /**
     * Obtener siguiente nivel
     */
    public function getNextLevel(): ?self
    {
        return self::where('is_active', true)
            ->where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();
    }

    /**
     * Obtener nivel anterior
     */
    public function getPreviousLevel(): ?self
    {
        return self::where('is_active', true)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    /**
     * Verificar si es el nivel más alto
     */
    public function isMaxLevel(): bool
    {
        return $this->getNextLevel() === null;
    }

    /**
     * Scope para niveles activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordenados
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
