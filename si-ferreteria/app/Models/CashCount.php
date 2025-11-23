<?php

namespace App\Models;

use App\Enums\CountStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashCount extends Model
{
    protected $fillable = [
        'cash_register_id',
        'system_amount',
        'bills_200',
        'bills_100',
        'bills_50',
        'bills_20',
        'bills_10',
        'coins_5',
        'coins_2',
        'coins_1',
        'coins_050',
        'total_cash',
        'total_cards',
        'total_qr',
        'total_counted',
        'difference',
        'difference_percentage',
        'justification',
        'status',
    ];

    protected $casts = [
        'system_amount' => 'decimal:2',
        'coins_050' => 'decimal:2',
        'total_cash' => 'decimal:2',
        'total_cards' => 'decimal:2',
        'total_qr' => 'decimal:2',
        'total_counted' => 'decimal:2',
        'difference' => 'decimal:2',
        'difference_percentage' => 'decimal:2',
        'status' => CountStatus::class,
    ];

    // ========== RELACIONES ==========
    
    public function cashRegister(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class);
    }

    // ========== MÉTODOS DE CÁLCULO ==========
    
    public function calculateTotals(): void
    {
        // Calcular total de efectivo
        $this->total_cash = 
            ($this->bills_200 * 200) +
            ($this->bills_100 * 100) +
            ($this->bills_50 * 50) +
            ($this->bills_20 * 20) +
            ($this->bills_10 * 10) +
            ($this->coins_5 * 5) +
            ($this->coins_2 * 2) +
            ($this->coins_1 * 1) +
            ($this->coins_050);

        // Calcular total contado
        $this->total_counted = $this->total_cash + $this->total_cards + $this->total_qr;

        // Calcular diferencia
        $this->difference = $this->total_counted - $this->system_amount;

        // Calcular porcentaje
        if ($this->system_amount > 0) {
            $this->difference_percentage = ($this->difference / $this->system_amount) * 100;
        } else {
            $this->difference_percentage = 0;
        }

        // Determinar estado
        $absPercentage = abs($this->difference_percentage);
        
        if ($absPercentage > 2) {
            $this->status = CountStatus::CRITICAL;
        } elseif ($this->difference != 0) {
            $this->status = CountStatus::WITH_DIFFERENCE;
        } else {
            $this->status = CountStatus::NORMAL;
        }
    }

    // ========== MÉTODOS AUXILIARES ==========
    
    public function hasDifference(): bool
    {
        return $this->difference != 0;
    }

    public function isCritical(): bool
    {
        return $this->status === CountStatus::CRITICAL;
    }

    public function isNormal(): bool
    {
        return $this->status === CountStatus::NORMAL;
    }

    public function needsJustification(): bool
    {
        return $this->hasDifference() && abs($this->difference_percentage) > 2;
    }
}