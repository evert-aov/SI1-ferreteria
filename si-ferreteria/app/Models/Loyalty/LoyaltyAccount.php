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
     * Relación con el nivel de membresía
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LoyaltyLevel::class, 'membership_level', 'code');
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
        $level = LoyaltyLevel::getLevelForPoints($this->total_points_earned);
        return $level ? $level->code : 'bronze';
    }

    /**
     * Obtener multiplicador de puntos del nivel actual
     */
    public function getPointsMultiplier(): float
    {
        return $this->level?->multiplier ?? 1.0;
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
     * Obtener nombre del nivel
     */
    public function getLevelNameAttribute(): string
    {
        return $this->level?->name ?? 'Desconocido';
    }

    /**
     * Obtener color del nivel
     */
    public function getLevelColorAttribute(): string
    {
        return $this->level?->color ?? '#6B7280';
    }

    /**
     * Obtener ícono del nivel
     */
    public function getLevelIconAttribute(): string
    {
        return $this->level?->icon ?? '⭐';
    }

    /**
     * Obtener progreso al siguiente nivel
     */
    public function getProgressToNextLevelAttribute(): array
    {
        $current = $this->total_points_earned;
        $currentLevel = $this->level;
        
        if (!$currentLevel) {
            return [
                'current' => $current,
                'required' => 0,
                'percentage' => 0,
                'next_level' => null,
            ];
        }

        $nextLevel = $currentLevel->getNextLevel();
        
        if (!$nextLevel) {
            // Es el nivel máximo
            return [
                'current' => $current,
                'required' => $currentLevel->min_points,
                'percentage' => 100,
                'next_level' => null,
            ];
        }

        $progress = $current - $currentLevel->min_points;
        $required = $nextLevel->min_points - $currentLevel->min_points;
        $percentage = $required > 0 ? min(100, ($progress / $required) * 100) : 100;

        return [
            'current' => $current,
            'required' => $nextLevel->min_points,
            'percentage' => round($percentage, 1),
            'next_level' => $nextLevel->name,
        ];
    }
}
