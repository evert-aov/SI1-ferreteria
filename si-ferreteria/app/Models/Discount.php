<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discount extends Model
{
    protected $fillable = [
        'description',
        'discount_type',
        'discount_value',
        'code',
        'max_uses',
        'used_count',
        'min_amount',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function ($discount) {
            $now = now();

            $discount->is_active = !(
                ($discount->start_date && $now->lt($discount->start_date)) ||
                ($discount->end_date && $now->gt($discount->end_date))
            );

            if (!$discount->code) {
                $discount->code = self::generateCode();
            }
        });
    }

    /**
     * Genera un código de descuento único verificando en BD.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'DSC-' . Str::upper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Verifica si el cupón es válido para usar
     */
    public function isValid(): bool
    {
        $now = now();
        
        // Verificar fechas
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }
        
        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }
        
        // Verificar si está activo
        if (!$this->is_active) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Verifica si el cupón puede ser usado (tiene usos disponibles)
     */
    public function canBeUsed(): bool
    {
        return $this->used_count < $this->max_uses;
    }
    
    /**
     * Verifica si el monto cumple con el mínimo requerido
     */
    public function meetsMinimumAmount(float $amount): bool
    {
        if (!$this->min_amount) {
            return true;
        }
        
        return $amount >= $this->min_amount;
    }
    
    /**
     * Calcula el monto de descuento a aplicar
     */
    public function toApplyDiscount(float $amount): float
    {
        if (!$this->isValid() || !$this->canBeUsed() || !$this->meetsMinimumAmount($amount)) {
            return 0;
        }
        
        if ($this->discount_type === 'PERCENTAGE') {
            return $amount * ($this->discount_value / 100);
        }

        return min($this->discount_value, $amount);
    }
    
    /**
     * Incrementa el contador de usos
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
