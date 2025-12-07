<?php

namespace App\Models\Loyalty;

use App\Models\User_security\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoyaltyAccount extends Model
{
    protected $fillable = [
        'customer_id',
        'total_points_earned',
        'available_points',
        'membership_level',
        'level_updated_at',
    ];

    protected $casts = [
        'level_updated_at' => 'datetime',
    ];

    /**
     * Relación con el cliente
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Relación con transacciones
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    /**
     * Relación con canjes
     */
    public function redemptions(): HasMany
    {
        return $this->hasMany(LoyaltyRedemption::class);
    }

    /**
     * Agregar puntos a la cuenta
     */
    public function addPoints(int $points, string $description, $reference = null): LoyaltyTransaction
    {
        $this->total_points_earned += $points;
        $this->available_points += $points;
        $this->save();

        // Actualizar nivel de membresía
        $this->updateMembershipLevel();

        // Crear transacción
        return $this->transactions()->create([
            'type' => 'earn',
            'points' => $points,
            'balance_after' => $this->available_points,
            'description' => $description,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference?->id,
            'expires_at' => now()->addMonths(12), // Puntos expiran en 12 meses
        ]);
    }

    /**
     * Redimir puntos
     */
    public function redeemPoints(int $points, string $description): LoyaltyTransaction
    {
        if ($this->available_points < $points) {
            throw new \Exception('Puntos insuficientes');
        }

        $this->available_points -= $points;
        $this->save();

        return $this->transactions()->create([
            'type' => 'redeem',
            'points' => -$points,
            'balance_after' => $this->available_points,
            'description' => $description,
        ]);
    }

    /**
     * Actualizar nivel de membresía según puntos totales
     */
    public function updateMembershipLevel(): void
    {
        $oldLevel = $this->membership_level;
        $newLevel = $this->calculateLevel();

        if ($oldLevel !== $newLevel) {
            $this->membership_level = $newLevel;
            $this->level_updated_at = now();
            $this->save();
        }
    }

    /**
     * Calcular nivel según puntos totales
     */
    private function calculateLevel(): string
    {
        if ($this->total_points_earned >= 500) {
            return 'gold';
        } elseif ($this->total_points_earned >= 100) {
            return 'silver';
        }
        
        return 'bronze';
    }

    /**
     * Obtener puntos próximos a vencer
     */
    public function expiringPoints(int $days = 30)
    {
        return $this->transactions()
            ->where('type', 'earn')
            ->where('expires_at', '<=', now()->addDays($days))
            ->where('expires_at', '>', now())
            ->sum('points');
    }

    /**
     * Obtener nombre del nivel en español
     */
    public function getLevelNameAttribute(): string
    {
        return match($this->membership_level) {
            'bronze' => 'Bronce',
            'silver' => 'Plata',
            'gold' => 'Oro',
            default => 'Desconocido'
        };
    }

    /**
     * Obtener color del nivel
     */
    public function getLevelColorAttribute(): string
    {
        return match($this->membership_level) {
            'bronze' => '#CD7F32',
            'silver' => '#C0C0C0',
            'gold' => '#FFD700',
            default => '#6B7280'
        };
    }

    /**
     * Obtener progreso al siguiente nivel
     */
    public function getProgressToNextLevelAttribute(): array
    {
        $current = $this->total_points_earned;
        
        if ($this->membership_level === 'gold') {
            return [
                'current' => $current,
                'required' => 500,
                'percentage' => 100,
                'next_level' => null,
            ];
        }

        $thresholds = [
            'bronze' => ['min' => 0, 'max' => 100, 'next' => 'Plata'],
            'silver' => ['min' => 100, 'max' => 500, 'next' => 'Oro'],
        ];

        $threshold = $thresholds[$this->membership_level];
        $progress = $current - $threshold['min'];
        $required = $threshold['max'] - $threshold['min'];
        $percentage = min(100, ($progress / $required) * 100);

        return [
            'current' => $current,
            'required' => $threshold['max'],
            'percentage' => round($percentage, 1),
            'next_level' => $threshold['next'],
        ];
    }
}
